(function() {
    rivets.binders.input = {
        publishes: true,
        routine: rivets.binders.value.routine,
        bind: function(el) {
            return $(el).bind('input.rivets', this.publish);
        },
        unbind: function(el) {
            return $(el).unbind('input.rivets');
        }
    };

    rivets.configure({
        prefix: "rv",
        adapter: {
            subscribe: function(obj, keypath, callback) {
                callback.wrapped = function(m, v) {
                    return callback(v);
                };
                return obj.on('change:' + keypath, callback.wrapped);
            },
            unsubscribe: function(obj, keypath, callback) {
                return obj.off('change:' + keypath, callback.wrapped);
            },
            read: function(obj, keypath) {
                if (keypath === "cid") {
                    return obj.cid;
                }
                return obj.get(keypath);
            },
            publish: function(obj, keypath, value) {
                if (obj.cid) {
                    return obj.set(keypath, value);
                } else {
                    return obj[keypath] = value;
                }
            }
        }
    });

}).call(this);

(function() {
    var BuilderView, EditFieldView, Formbuilder, FormbuilderCollection, FormbuilderModel, ViewFieldView, _ref, _ref1, _ref2, _ref3, _ref4,
            __hasProp = {}.hasOwnProperty,
            __extends = function(child, parent) {
                for (var key in parent) {
                    if (__hasProp.call(parent, key))
                        child[key] = parent[key];
                }
                function ctor() {
                    this.constructor = child;
                }
                ctor.prototype = parent.prototype;
                child.prototype = new ctor();
                child.__super__ = parent.prototype;
                return child;
            };

    FormbuilderModel = (function(_super) {
        __extends(FormbuilderModel, _super);

        function FormbuilderModel() {
            _ref = FormbuilderModel.__super__.constructor.apply(this, arguments);
            return _ref;
        }

        FormbuilderModel.prototype.sync = function() {
        };

        FormbuilderModel.prototype.indexInDOM = function() {
            var $wrapper,
                    _this = this;
            $wrapper = $(".fb-field-wrapper").filter((function(_, el) {
                return $(el).data('cid') === _this.cid;
            }));
            return $(".fb-field-wrapper").index($wrapper);
        };

        FormbuilderModel.prototype.is_input = function() {
            return Formbuilder.inputFields[this.get(Formbuilder.options.mappings.FIELD_TYPE)] != null;
        };

        return FormbuilderModel;

    })(Backbone.DeepModel);

    FormbuilderCollection = (function(_super) {
        __extends(FormbuilderCollection, _super);

        function FormbuilderCollection() {
            _ref1 = FormbuilderCollection.__super__.constructor.apply(this, arguments);
            return _ref1;
        }

        FormbuilderCollection.prototype.initialize = function() {
            return this.on('add', this.copyCidToModel);
        };

        FormbuilderCollection.prototype.model = FormbuilderModel;

        FormbuilderCollection.prototype.comparator = function(model) {
            return model.indexInDOM();
        };

        FormbuilderCollection.prototype.copyCidToModel = function(model) {
            return model.attributes.cid = model.cid;
        };

        return FormbuilderCollection;

    })(Backbone.Collection);

    ViewFieldView = (function(_super) {
        __extends(ViewFieldView, _super);

        function ViewFieldView() {
            _ref2 = ViewFieldView.__super__.constructor.apply(this, arguments);
            return _ref2;
        }

        ViewFieldView.prototype.className = "fb-field-wrapper";

        ViewFieldView.prototype.events = {
            'click .subtemplate-wrapper': 'focusEditView',
            'click .js-duplicate': 'duplicate',
            'click .js-clear': 'clear'
        };

        ViewFieldView.prototype.initialize = function(options) {
            this.parentView = options.parentView;
            this.listenTo(this.model, "change", this.render);
            return this.listenTo(this.model, "destroy", this.remove);
        };

        ViewFieldView.prototype.render = function() {
            this.$el.addClass('response-field-' + this.model.get(Formbuilder.options.mappings.FIELD_TYPE)).data('cid', this.model.cid).html(Formbuilder.templates["view/base" + (!this.model.is_input() ? '_non_input' : '')]({
                rf: this.model
            }));
            return this;
        };

        ViewFieldView.prototype.focusEditView = function() {
            return this.parentView.createAndShowEditView(this.model);
        };

        ViewFieldView.prototype.clear = function(e) {
            var cb, x,
                    _this = this;
            e.preventDefault();
            e.stopPropagation();
            cb = function() {
                _this.parentView.handleFormUpdate();
                return _this.model.destroy();
            };
            x = Formbuilder.options.CLEAR_FIELD_CONFIRM;
            switch (typeof x) {
                case 'string':
                    if (confirm(x)) {
                        return cb();
                    }
                    break;
                case 'function':
                    return x(cb);
                default:
                    return cb();
            }
        };

        ViewFieldView.prototype.duplicate = function() {
            var attrs;
            attrs = _.clone(this.model.attributes);
            delete attrs['id'];
            attrs['label'] += ' Copy';
            return this.parentView.createField(attrs, {
                position: this.model.indexInDOM() + 1
            });
        };

        return ViewFieldView;

    })(Backbone.View);

    EditFieldView = (function(_super) {
        __extends(EditFieldView, _super);

        function EditFieldView() {
            _ref3 = EditFieldView.__super__.constructor.apply(this, arguments);
            return _ref3;
        }

        EditFieldView.prototype.className = "edit-response-field";

        EditFieldView.prototype.events = {
            'click .js-add-option': 'addOption',
            'click .js-remove-option': 'removeOption',
            'click .js-default-updated': 'defaultUpdated',
            'input .option-label-input': 'forceRender'
        };

        EditFieldView.prototype.initialize = function(options) {
            this.parentView = options.parentView;
            return this.listenTo(this.model, "destroy", this.remove);
        };

        EditFieldView.prototype.render = function() {
            this.$el.html(Formbuilder.templates["edit/base" + (!this.model.is_input() ? '_non_input' : '')]({
                rf: this.model
            }));
            rivets.bind(this.$el, {
                model: this.model
            });
            return this;
        };

        EditFieldView.prototype.remove = function() {
            this.parentView.editView = void 0;
            this.parentView.$el.find("[data-target=\"#addField\"]").click();
            return EditFieldView.__super__.remove.apply(this, arguments);
        };

        EditFieldView.prototype.addOption = function(e) {
            var $el, i, newOption, options;
            $el = $(e.currentTarget);
            i = this.$el.find('.option').index($el.closest('.option'));
            options = this.model.get(Formbuilder.options.mappings.OPTIONS) || [];
            newOption = {
                label: "",
                value: '',
                checked: false
            };
            if (i > -1) {
                options.splice(i + 1, 0, newOption);
            } else {
                options.push(newOption);
            }
            this.model.set(Formbuilder.options.mappings.OPTIONS, options);
            this.model.trigger("change:" + Formbuilder.options.mappings.OPTIONS);
            return this.forceRender();
        };

        EditFieldView.prototype.removeOption = function(e) {
            var $el, index, options;
            $el = $(e.currentTarget);
            index = this.$el.find(".js-remove-option").index($el);
            options = this.model.get(Formbuilder.options.mappings.OPTIONS);
            options.splice(index, 1);
            this.model.set(Formbuilder.options.mappings.OPTIONS, options);
            this.model.trigger("change:" + Formbuilder.options.mappings.OPTIONS);
            return this.forceRender();
        };

        EditFieldView.prototype.defaultUpdated = function(e) {
            var $el;
            $el = $(e.currentTarget);
            if (this.model.get(Formbuilder.options.mappings.FIELD_TYPE) !== 'checkboxes') {
                this.$el.find(".js-default-updated").not($el).attr('checked', false).trigger('change');
            }
            return this.forceRender();
        };

        EditFieldView.prototype.forceRender = function() {
            return this.model.trigger('change');
        };

        return EditFieldView;

    })(Backbone.View);

    BuilderView = (function(_super) {
        __extends(BuilderView, _super);

        function BuilderView() {
            _ref4 = BuilderView.__super__.constructor.apply(this, arguments);
            return _ref4;
        }

        BuilderView.prototype.SUBVIEWS = [];

        BuilderView.prototype.events = {
            'click .js-save-form': 'saveForm',
            'click .fb-tabs a': 'showTab',
            'click .fb-add-field-types a': 'addField',
            'mouseover .fb-add-field-types': 'lockLeftWrapper',
            'mouseout .fb-add-field-types': 'unlockLeftWrapper',
            'change .edit-response-field .changbttype': 'showScript'
        };

        BuilderView.prototype.initialize = function(options) {
            var selector;
            selector = options.selector, this.formBuilder = options.formBuilder, this.bootstrapData = options.bootstrapData;
            if (selector != null) {
                this.setElement($(selector));
            }
            this.collection = new FormbuilderCollection;
            this.collection.bind('add', this.addOne, this);
            this.collection.bind('reset', this.reset, this);
            this.collection.bind('change', this.handleFormUpdate, this);
            this.collection.bind('destroy add reset', this.hideShowNoResponseFields, this);
            this.collection.bind('destroy', this.ensureEditViewScrolled, this);
            this.render();
            this.collection.reset(this.bootstrapData);
            return this.bindSaveEvent();
        };

        BuilderView.prototype.bindSaveEvent = function() {
            var _this = this;
            this.formSaved = true;
            this.saveFormButton = this.$el.find(".js-save-form");
            this.saveFormButton.attr('disabled', true).text(Formbuilder.options.dict.ALL_CHANGES_SAVED);
            if (!!Formbuilder.options.AUTOSAVE) {
                setInterval(function() {
                    return _this.saveForm.call(_this);
                }, 5000);
            }
            return $(window).bind('beforeunload', function() {
                if (_this.formSaved) {
                    return void 0;
                } else {
                    return Formbuilder.options.dict.UNSAVED_CHANGES;
                }
            });
        };

        BuilderView.prototype.reset = function() {
            this.$responseFields.html('');
            return this.addAll();
        };

        BuilderView.prototype.render = function() {
            var subview, _i, _len, _ref5;
            this.$el.html(Formbuilder.templates['page']());
            this.$fbLeft = this.$el.find('.fb-left');
            this.$responseFields = this.$el.find('.fb-response-fields');
            this.bindWindowScrollEvent();
            this.hideShowNoResponseFields();
            _ref5 = this.SUBVIEWS;
            for (_i = 0, _len = _ref5.length; _i < _len; _i++) {
                subview = _ref5[_i];
                new subview({
                    parentView: this
                }).render();
            }
            return this;
        };

        // scroll left
        BuilderView.prototype.bindWindowScrollEvent = function() {
            return false;
            var _this = this;
            return $(window).on('scroll', function() {
                var maxMargin, newMargin;
                if (_this.$fbLeft.data('locked') === true) {
                    return;
                }
                newMargin = Math.max(0, $(window).scrollTop() - _this.$el.offset().top);
                maxMargin = _this.$responseFields.height();
                return _this.$fbLeft.css({
                    'margin-top': Math.min(maxMargin, newMargin)
                });
            });
        };

        BuilderView.prototype.showTab = function(e) {
            var $el, first_model, target;
            $el = $(e.currentTarget);
            target = $el.parents('.fb-tabs').next().find($el.data('target'));
            $el.closest('li').addClass('active').siblings('li').removeClass('active');
            $(target).addClass('active').siblings('.fb-tab-pane').removeClass('active');
            if (target !== '#editField') {
                this.unlockLeftWrapper();
            }
            if (target === '#editField' && !this.editView && (first_model = this.collection.models[0])) {
                return this.createAndShowEditView(first_model);
            }
        };
//        BuilderView.prototype.showTab = function(e) {
//            var $el, first_model, target;
//            $el = $(e.currentTarget);
//            target = $el.data('target');
//            $el.closest('li').addClass('active').siblings('li').removeClass('active');
//            $(target).addClass('active').siblings('.fb-tab-pane').removeClass('active');
//            if (target !== '#editField') {
//                this.unlockLeftWrapper();
//            }
//            if (target === '#editField' && !this.editView && (first_model = this.collection.models[0])) {
//                return this.createAndShowEditView(first_model);
//            }
//        };

        BuilderView.prototype.addOne = function(responseField, _, options) {
            var $replacePosition, view;
            view = new ViewFieldView({
                model: responseField,
                parentView: this
            });
            if (options.$replaceEl != null) {
                return options.$replaceEl.replaceWith(view.render().el);
            } else if ((options.position == null) || options.position === -1) {
                return this.$responseFields.append(view.render().el);
            } else if (options.position === 0) {
                return this.$responseFields.prepend(view.render().el);
            } else if (($replacePosition = this.$responseFields.find(".fb-field-wrapper").eq(options.position))[0]) {
                return $replacePosition.before(view.render().el);
            } else {
                return this.$responseFields.append(view.render().el);
            }
        };

        BuilderView.prototype.setSortable = function() {
            var _this = this;
            if (this.$responseFields.hasClass('ui-sortable')) {
                this.$responseFields.sortable('destroy');
            }
            this.$responseFields.sortable({
                forcePlaceholderSize: true,
                placeholder: 'sortable-placeholder',
                stop: function(e, ui) {
                    var rf;
                    if (ui.item.data('field-type')) {
                        rf = _this.collection.create(Formbuilder.helpers.defaultFieldAttrs(ui.item.data('field-type')), {
                            $replaceEl: ui.item
                        });
                        //don't show edit view
                        //_this.createAndShowEditView(rf);
                    }
                    _this.handleFormUpdate();
                    return true;
                },
                update: function(e, ui) {
                    if (!ui.item.data('field-type')) {
                        return _this.ensureEditViewScrolled();
                    }
                }
            });
            return this.setDraggable();
        };

        BuilderView.prototype.setDraggable = function() {
            var $addFieldButtons,
                    _this = this;
            $addFieldButtons = this.$el.find("[data-field-type]");
            return $addFieldButtons.draggable({
                connectToSortable: this.$responseFields,
                helper: function() {
                    var $helper;
                    $helper = $("<div class='response-field-draggable-helper' />");
                    $helper.css({
                        width: _this.$responseFields.width(),
                        height: '80px'
                    });
                    return $helper;
                }
            });
        };
        BuilderView.prototype.showScript = function() {
            if (this.$el.find(".edit-response-field .changbttype").val() != 'click')
                this.$el.find(".edit-response-field .buttonscript").hide();
            else {
                this.$el.find(".edit-response-field .buttonscript").show();
            }
        };
        BuilderView.prototype.addAll = function() {
            this.collection.each(this.addOne, this);
            return this.setSortable();
        };

        BuilderView.prototype.hideShowNoResponseFields = function() {
            return this.$el.find(".fb-no-response-fields")[this.collection.length > 0 ? 'hide' : 'show']();
        };

        BuilderView.prototype.addField = function(e) {
            var field_type;
            field_type = $(e.currentTarget).data('field-type');
            return this.createField(Formbuilder.helpers.defaultFieldAttrs(field_type));
        };

        BuilderView.prototype.createField = function(attrs, options) {
            var rf;
            rf = this.collection.create(attrs, options);
            //this.createAndShowEditView(rf);
            return this.handleFormUpdate();
        };

        BuilderView.prototype.createAndShowEditView = function(model) {
            var $newEditEl, $responseFieldEl;
            $responseFieldEl = this.$el.find(".fb-field-wrapper").filter(function() {
                return $(this).data('cid') === model.cid;
            });
            $responseFieldEl.addClass('editing').siblings('.fb-field-wrapper').removeClass('editing');
            if (this.editView) {
                if (this.editView.model.cid === model.cid) {
                    this.$el.find(".fb-tabs a[data-target=\"#editField\"]").click();
                    this.scrollLeftWrapper($responseFieldEl);
                    return;
                }
                this.editView.remove();
            }
            this.editView = new EditFieldView({
                model: model,
                parentView: this
            });
            $newEditEl = this.editView.render().$el;
            this.$el.find(".fb-edit-field-wrapper").html($newEditEl);
            this.$el.find(".fb-tabs a[data-target=\"#editField\"]").click();
            this.scrollLeftWrapper($responseFieldEl);
            return this;
        };

        BuilderView.prototype.ensureEditViewScrolled = function() {
            if (!this.editView) {
                return;
            }
            return this.scrollLeftWrapper($(".fb-field-wrapper.editing"));
        };

        BuilderView.prototype.scrollLeftWrapper = function($responseFieldEl) {
            var _this = this;
            this.unlockLeftWrapper();
            if (!$responseFieldEl[0]) {
                return;
            }
            return $.scrollWindowTo((this.$el.offset().top + $responseFieldEl.offset().top) - this.$responseFields.offset().top, 200, function() {
                return _this.lockLeftWrapper();
            });
        };

        BuilderView.prototype.lockLeftWrapper = function() {
            return this.$fbLeft.data('locked', true);
        };

        BuilderView.prototype.unlockLeftWrapper = function() {
            return this.$fbLeft.data('locked', false);
        };

        BuilderView.prototype.handleFormUpdate = function() {
            if (this.updatingBatch) {
                return;
            }
            this.formSaved = false;
            return this.saveFormButton.removeAttr('disabled').text(Formbuilder.options.dict.SAVE_FORM);
        };

        BuilderView.prototype.saveForm = function(e) {
            var payload;
            if (this.formSaved) {
                return;
            }
            this.formSaved = true;
            this.saveFormButton.attr('disabled', true).text(Formbuilder.options.dict.ALL_CHANGES_SAVED);
            this.collection.sort();
            payload = JSON.stringify({
                fields: this.collection.toJSON()
            });
            if (Formbuilder.options.HTTP_ENDPOINT) {
                this.doAjaxSave(payload);
            }
            this.formBuilder.trigger('save', payload);
            return false;
        };

        BuilderView.prototype.doAjaxSave = function(payload) {
            var _this = this;
            return $.ajax({
                url: Formbuilder.options.HTTP_ENDPOINT,
                type: Formbuilder.options.HTTP_METHOD,
                data: payload,
                contentType: "application/json",
                success: function(data) {
                    var datum, _i, _len, _ref5;
                    _this.updatingBatch = true;
                    for (_i = 0, _len = data.length; _i < _len; _i++) {
                        datum = data[_i];
                        if ((_ref5 = _this.collection.get(datum.cid)) != null) {
                            _ref5.set({
                                id: datum.id
                            });
                        }
                        _this.collection.trigger('sync');
                    }
                    return _this.updatingBatch = void 0;
                }
            });
        };

        return BuilderView;

    })(Backbone.View);

    Formbuilder = (function() {
        Formbuilder.helpers = {
            defaultFieldAttrs: function(field_type) {
                var attrs, _base;
                attrs = {};
                attrs[Formbuilder.options.mappings.LABEL] = 'Tên trường';
                attrs[Formbuilder.options.mappings.FIELD_TYPE] = field_type;
                attrs[Formbuilder.options.mappings.FIELD_ID] = '';
                attrs[Formbuilder.options.mappings.REQUIRED] = true;
                //attrs[Formbuilder.options.mappings.ITEM_NAME] = 'Item name';
                //attrs[Formbuilder.options.mappings.ITEM_DESCRIPTION] = 'Item description';
                //attrs[Formbuilder.options.mappings.ITEM_CODE] = 'Item code';
                attrs['field_options'] = {
                    "size": "large"
                };
                return (typeof (_base = Formbuilder.fields[field_type]).defaultAttributes === "function" ? _base.defaultAttributes(attrs) : void 0) || attrs;
            },
            simple_format: function(x) {
                return x != null ? x.replace(/\n/g, '<br />') : void 0;
            }
        };

        Formbuilder.options = {
            BUTTON_CLASS: 'fb-button',
            HTTP_ENDPOINT: '',
            HTTP_METHOD: 'POST',
            AUTOSAVE: true,
            CLEAR_FIELD_CONFIRM: false,
            mappings: {
                SIZE: 'field_options.size',
                UNITS: 'field_options.units',
                LABEL: 'label',
                FIELD_ID: 'field_id',
                FIELD_TYPE: 'field_type',
                REQUIRED: 'required',
                ADMIN_ONLY: 'admin_only',
                OPTIONS: 'field_options.options',
                DESCRIPTION: 'field_options.description',
                INCLUDE_OTHER: 'field_options.include_other_option',
                INCLUDE_BLANK: 'field_options.include_blank_option',
                INTEGER_ONLY: 'field_options.integer_only',
                MIN: 'field_options.min',
                MAX: 'field_options.max',
                MINLENGTH: 'field_options.minlength',
                MAXLENGTH: 'field_options.maxlength',
                ITEM_NAME: 'item_name',
                ITEM_DESCRIPTION: 'item_description',
                ITEM_CODE: 'item_code',
                LENGTH_UNITS: 'field_options.min_max_length_units',
                DATE_FORMAT: 'field_options.dateformat',
                BUTTON_TYPE: 'field_options.button_type',
                FILE_TYPE: 'field_options.file_type',
                SITE_KEY: 'field_options.site_key',
                SECRET_KEY: 'field_options.secret_key',
                ONCLICK: 'field_options.onclick'
            },
            dict: {
                ALL_CHANGES_SAVED: 'All changes saved',
                SAVE_FORM: 'Save form',
                UNSAVED_CHANGES: 'You have unsaved changes. If you leave this page, you will lose those changes!'
            }
        };
        Formbuilder.item = {
            name: '',
            description: '',
            code: ''
        };
        Formbuilder.fields = {};

        Formbuilder.inputFields = {};

        Formbuilder.nonInputFields = {};

        Formbuilder.registerField = function(name, opts) {
            var x, _i, _len, _ref5;
            _ref5 = ['view', 'edit'];
            for (_i = 0, _len = _ref5.length; _i < _len; _i++) {
                x = _ref5[_i];
                opts[x] = _.template(opts[x]);
            }
            opts.field_type = name;
            Formbuilder.fields[name] = opts;
            if (opts.type === 'non_input') {
                return Formbuilder.nonInputFields[name] = opts;
            } else {
                return Formbuilder.inputFields[name] = opts;
            }
        };

        function Formbuilder(opts) {
            var args;
            if (opts == null) {
                opts = {};
            }
            _.extend(this, Backbone.Events);
            args = _.extend(opts, {
                formBuilder: this
            });
            this.mainView = new BuilderView(args);
        }

        return Formbuilder;

    })();

    window.Formbuilder = Formbuilder;

    if (typeof module !== "undefined" && module !== null) {
        module.exports = Formbuilder;
    } else {
        window.Formbuilder = Formbuilder;
    }

}).call(this);
(function() {
    Formbuilder.registerField('heading', {
        order: 0,
        type: 'non_input',
        view: "<label class='section-name'><%= rf.get(Formbuilder.options.mappings.LABEL) %></label>\n<p><%= rf.get(Formbuilder.options.mappings.DESCRIPTION) %></p>",
        edit: "<div class='fb-edit-section-header'>Tiêu đề</div>\n<input type='text' data-rv-input='model.<%= Formbuilder.options.mappings.LABEL %>' />\n<textarea data-rv-input='model.<%= Formbuilder.options.mappings.DESCRIPTION %>'\n  placeholder='Thêm miêu tả cho trường này'></textarea>",
        addButton: "<span class='symbol'><span class='fa fa-minus'></span></span> Heading",
        defaultAttributes: function(attrs) {
            attrs.required = false;
            return attrs;
        }
    });

}).call(this);

(function() {
    Formbuilder.registerField('text', {
        order: 0,
        view: "<input type='text' class='rf-size-<%= rf.get(Formbuilder.options.mappings.SIZE) %>' />",
        edit: "<%= Formbuilder.templates['edit/size']() %>\n<%= Formbuilder.templates['edit/min_max_length']()%>",
        addButton: "<span class='symbol'><span class='fa fa-font'></span></span> Text box",
        defaultAttributes: function(attrs) {
            attrs.field_options.size = 'large';
            return attrs;
        }
    });

}).call(this);

(function() {
    Formbuilder.registerField('paragraph', {
        order: 5,
        view: "<textarea class='rf-size-<%= rf.get(Formbuilder.options.mappings.SIZE) %>'></textarea>",
        edit: "<%= Formbuilder.templates['edit/size']() %>\n<%= Formbuilder.templates['edit/min_max_length']() %>",
        addButton: "<span class=\"symbol\">&#182;</span> Text area",
        defaultAttributes: function(attrs) {
            attrs.field_options.size = 'large';
            return attrs;
        }
    });

}).call(this);

(function() {
    Formbuilder.registerField('checkboxes', {
        order: 10,
        view: "<% for (i in (rf.get(Formbuilder.options.mappings.OPTIONS) || [])) { %>\n  <div>\n    <label class='fb-option'>\n      <input type='checkbox' <%= rf.get(Formbuilder.options.mappings.OPTIONS)[i].checked && 'checked' %> onclick=\"javascript: return false;\" />\n      <%= rf.get(Formbuilder.options.mappings.OPTIONS)[i].label %>\n    </label>\n  </div>\n<% } %>\n\n<% if (rf.get(Formbuilder.options.mappings.INCLUDE_OTHER)) { %>\n  <div class='other-option'>\n    <label class='fb-option'>\n      <input type='checkbox' />\n      Other\n    </label>\n\n    <input type='text' />\n  </div>\n<% } %>",
        edit: "<%= Formbuilder.templates['edit/options']({ includeOther: true }) %>",
        addButton: "<span class=\"symbol\"><span class=\"fa fa-square-o\"></span></span> Check box",
        defaultAttributes: function(attrs) {
            attrs.field_options.options = [
                {
                    label: "",
                    value: "",
                    checked: false
                }, {
                    label: "",
                    value: "",
                    checked: false
                }
            ];
            return attrs;
        }
    });

}).call(this);

(function() {
    Formbuilder.registerField('radio', {
        order: 15,
        view: "<% for (i in (rf.get(Formbuilder.options.mappings.OPTIONS) || [])) { %>\n  <div>\n    <label class='fb-option'>\n      <input type='radio' <%= rf.get(Formbuilder.options.mappings.OPTIONS)[i].checked && 'checked' %> onclick=\"javascript: return false;\" />\n      <%= rf.get(Formbuilder.options.mappings.OPTIONS)[i].label %>\n    </label>\n  </div>\n<% } %>\n\n<% if (rf.get(Formbuilder.options.mappings.INCLUDE_OTHER)) { %>\n  <div class='other-option'>\n    <label class='fb-option'>\n      <input type='radio' />\n      Other\n    </label>\n\n    <input type='text' />\n  </div>\n<% } %>",
        edit: "<%= Formbuilder.templates['edit/options']({ includeOther: true }) %>",
        addButton: "<span class=\"symbol\"><span class=\"fa fa-circle-o\"></span></span> Radio button",
        defaultAttributes: function(attrs) {
            attrs.field_options.options = [
                {
                    label: "",
                    value: "",
                    checked: false
                }, {
                    label: "",
                    value: "",
                    checked: false
                }
            ];
            return attrs;
        }
    });

}).call(this);

(function() {
    Formbuilder.registerField('dropdown', {
        order: 20,
        view: "<select>\n  <% if (rf.get(Formbuilder.options.mappings.INCLUDE_BLANK)) { %>\n    <option value=''></option>\n  <% } %>\n\n  <% for (i in (rf.get(Formbuilder.options.mappings.OPTIONS) || [])) { %>\n    <option <%= rf.get(Formbuilder.options.mappings.OPTIONS)[i].checked && 'selected' %>>\n      <%= rf.get(Formbuilder.options.mappings.OPTIONS)[i].label %>\n    </option>\n  <% } %>\n</select>",
        edit: "<%= Formbuilder.templates['edit/options']({ includeBlank: true }) %>",
        addButton: "<span class=\"symbol\"><span class=\"fa fa-caret-down\"></span></span> Drop down",
        defaultAttributes: function(attrs) {
            attrs.field_options.options = [
                {
                    label: "",
                    value: "",
                    checked: false
                }, {
                    label: "",
                    value: "",
                    checked: false
                }
            ];
            attrs.field_options.include_blank_option = false;
            return attrs;
        }
    });

}).call(this);



(function() {
    Formbuilder.registerField('date', {
        order: 24,
        view: "<div class='input-line'>\n  <span class='rf-size-small'>\n    <input type=\"text\" />\n    <label><%= fbuilder.getDateFormatText(rf.get(Formbuilder.options.mappings.DATE_FORMAT))%></label>\n  \n</div>",
        edit: "<%= Formbuilder.templates['edit/date_fomat']() %>",
        addButton: "<span class=\"symbol\"><span class=\"fa fa-calendar\"></span></span> Date",
        defaultAttributes: function(attrs) {
            attrs.field_options.dateformat = 'dd/mm/yy';
            return attrs;
        }
    });

}).call(this);

(function() {
    Formbuilder.registerField('button', {
        order: 24,
        type: 'non_input',
        view: "<div class='input-line'>\n  <button class='btn'><%= rf.get(Formbuilder.options.mappings.LABEL) %></button>\n<p><%= rf.get(Formbuilder.options.mappings.DESCRIPTION) %></p></div>",
        edit: "<div class='fb-edit-section-header'>Nhãn</div>\n<div class='fb-common-wrapper'> <div class='fb-label-description'><input type='text' data-rv-input='model.<%= Formbuilder.options.mappings.LABEL %>' />\n<textarea data-rv-input='model.<%= Formbuilder.options.mappings.DESCRIPTION %>'\n  placeholder='Thêm miêu tả cho trường này'></textarea></div></div><%= Formbuilder.templates['button/type']({rf:rf}) %>",
        addButton: "<span class=\"symbol\"><span class=\"fa  fa-bold\"></span></span> Button",
        defaultAttributes: function(attrs) {
            attrs.field_options.onclick = '';
            attrs.label = 'Tên nút';
            attrs.field_options.button_type = 'click';
            attrs.required = false;
            return attrs;
        }
    });

}).call(this);

(function() {
    Formbuilder.registerField('file', {
        order: 55,
        view: "<input type='file' />",
        //edit: "<%= Formbuilder.templates['file/type']() %>",
        edit: "",
        addButton: "<span class=\"symbol\"><span class=\"fa fa-cloud-upload\"></span></span> File upload",
        defaultAttributes: function(attrs) {
            attrs.field_options.file_type = 'files';
            attrs.required = true;
            return attrs;
        }
    });

}).call(this);

(function() {
    Formbuilder.registerField('email', {
        order: 40,
        view: "<input type='text' class='rf-size-<%= rf.get(Formbuilder.options.mappings.SIZE) %>' />",
        edit: "",
        addButton: "<span class=\"symbol\"><span class=\"fa fa-envelope-o\"></span></span> Email"
    });

}).call(this);

(function() {
     Formbuilder.registerField('captcha', {
        order: 40,
        view: "<input type='text' class='rf-size-<%= rf.get(Formbuilder.options.mappings.SIZE) %>' /> Captcha",
        edit: "",
        addButton: "<span class=\"symbol\"><span class=\"fa fa-envelope-o\"></span></span> Captcha"
    });

}).call(this);
(function() {
     Formbuilder.registerField('recaptcha', {
        order: 40,
        view: "Google Captcha",
        edit: "<%= Formbuilder.templates['edit/recaptcha']() %>",
        addButton: "<span class=\"symbol\"><span class=\"fa fa-envelope-o\"></span></span> Google Captcha"
    });

}).call(this);

this["Formbuilder"] = this["Formbuilder"] || {};
this["Formbuilder"]["templates"] = this["Formbuilder"]["templates"] || {};

this["Formbuilder"]["templates"]["edit/base"] = function(obj) {
    obj || (obj = {});
    var __t, __p = '', __e = _.escape;
    with (obj) {
        __p +=
                ((__t = (Formbuilder.templates['edit/base_header']())) == null ? '' : __t) +
                '\n' +
                ((__t = (Formbuilder.templates['edit/common']())) == null ? '' : __t) +
                '\n' +
                ((__t = (Formbuilder.fields[rf.get(Formbuilder.options.mappings.FIELD_TYPE)].edit({rf: rf}))) == null ? '' : __t) +
                '\n';

    }
    return __p;
};

this["Formbuilder"]["templates"]["edit/base_header"] = function(obj) {
    obj || (obj = {});
    var __t, __p = '', __e = _.escape;
    with (obj) {
//        __p += '<div class=\'fb-field-label\'>\n  <span data-rv-text="model.' +
//                ((__t = (Formbuilder.options.mappings.LABEL)) == null ? '' : __t) +
//                '"></span>\n  <code class=\'field-type\' data-rv-text=\'model.' +
//                ((__t = (Formbuilder.options.mappings.FIELD_TYPE)) == null ? '' : __t) +
//                '\'></code>\n  <span class=\'fa fa-arrow-right pull-right\'></span>\n</div>';
//        __p += '<input type="hidden" data-rv-input="model.field_id" /><div class="fb-edit-section-header">Map to</div>' + fbuilder.getFieldCondition() + '</div>';
    }
    return __p;
};

this["Formbuilder"]["templates"]["edit/date_fomat"] = function(obj) {
    obj || (obj = {});
    var __t, __p = '', __e = _.escape;
    with (obj) {
//        __p += '<div class="fb-edit-section-header">Date format</div><select data-rv-value="model.' +
//                ((__t = (Formbuilder.options.mappings.DATE_FORMAT)) == null ? '' : __t) +
//                '" style="width: auto;">\n  <option value="mm/dd/yy">MM/DD/YYYY</option>\n  \n\
//                    <option value="dd/mm/yy">DD/MM/YYYY</option>\n <option value="mm-dd-yy">MM-DD-YYYY</option>\n\n\
//                    <option value="dd-mm-yy">DD-MM-YYYY</option>\n</select>\n';
        __p += '<div class="fb-edit-section-header">Định dạng ngày</div><select data-rv-value="model.' +
                ((__t = (Formbuilder.options.mappings.DATE_FORMAT)) == null ? '' : __t) +
                '" style="width: auto;">\n <option value="dd/mm/yy">Ngày/Tháng/Năm</option><option value="mm/dd/yy">Tháng/Ngày/Năm</option></select>';
    }
    return __p;
};

this["Formbuilder"]["templates"]["edit/recaptcha"] = function(obj) {
    obj || (obj = {});
    var __t, __p = '', __e = _.escape;
    with (obj) {
        __p += '<div class=\'fb-edit-section-header\'>Site Key: </div><div><input type="text" data-rv-input="model.' +
                ((__t = (Formbuilder.options.mappings.SITE_KEY)) == null ? '' : __t) +
                '" style="" /></div><div class=\'fb-edit-section-header\'>Secret Key: </div><div><input type="text" data-rv-input="model.' +
                ((__t = (Formbuilder.options.mappings.SECRET_KEY)) == null ? '' : __t) +
                '" style="" /></div>\n';

    }
    return __p;
};


this["Formbuilder"]["templates"]["edit/base_non_input"] = function(obj) {
    obj || (obj = {});
    var __t, __p = '', __e = _.escape;
    with (obj) {
        __p +=
                //((__t = (Formbuilder.templates['edit/base_header']())) == null ? '' : __t) +
                '\n' +
                ((__t = (Formbuilder.fields[rf.get(Formbuilder.options.mappings.FIELD_TYPE)].edit({rf: rf}))) == null ? '' : __t) +
                '\n';
    }
    return __p;
};

this["Formbuilder"]["templates"]["edit/checkboxes"] = function(obj) {
    obj || (obj = {});
    var __t, __p = '', __e = _.escape;
    with (obj) {
        __p += '<label>\n  <input type=\'checkbox\' data-rv-checked=\'model.' +
                ((__t = (Formbuilder.options.mappings.REQUIRED)) == null ? '' : __t) +
                '\' />\n  Yêu cầu nhập\n</label>\n<label>';
//                '\' />\n  Required\n</label>\n<label>\n  <input type=\'checkbox\' data-rv-checked=\'model.' +
//                ((__t = (Formbuilder.options.mappings.ADMIN_ONLY)) == null ? '' : __t) +
//                '\' />\n  Admin only\n</label>';

    }
    return __p;
};

this["Formbuilder"]["templates"]["edit/common"] = function(obj) {
    obj || (obj = {});
    var __t, __p = '', __e = _.escape;
    with (obj) {
        __p += '<div class=\'fb-edit-section-header\'>Tiêu đề</div>\n\n<div class=\'fb-common-wrapper\'>\n  <div class=\'fb-label-description\'>\n    ' +
                ((__t = (Formbuilder.templates['edit/label_description']())) == null ? '' : __t) +
                '\n  </div>\n  <div class=\'fb-common-checkboxes\'>\n    ' +
                ((__t = (Formbuilder.templates['edit/checkboxes']())) == null ? '' : __t) +
                '\n  </div>\n  <div class=\'fb-clear\'></div>\n</div>\n';

    }
    return __p;
};

this["Formbuilder"]["templates"]["edit/integer_only"] = function(obj) {
    obj || (obj = {});
    var __t, __p = '', __e = _.escape;
    with (obj) {
        __p += '<div class=\'fb-edit-section-header\'>Integer only</div>\n<label>\n  <input type=\'checkbox\' data-rv-checked=\'model.' +
                ((__t = (Formbuilder.options.mappings.INTEGER_ONLY)) == null ? '' : __t) +
                '\' />\n  Only accept integers\n</label>\n';

    }
    return __p;
};

this["Formbuilder"]["templates"]["edit/label_description"] = function(obj) {
    obj || (obj = {});
    var __t, __p = '', __e = _.escape;
    with (obj) {
        __p += '<input type=\'text\' data-rv-input=\'model.' +
                ((__t = (Formbuilder.options.mappings.LABEL)) == null ? '' : __t) +
                '\' />\n<textarea data-rv-input=\'model.' +
                ((__t = (Formbuilder.options.mappings.DESCRIPTION)) == null ? '' : __t) +
                '\'\n  placeholder=\'Thêm miêu tả cho trường này\'></textarea>';

    }
    return __p;
};

this["Formbuilder"]["templates"]["edit/min_max"] = function(obj) {
    obj || (obj = {});
    var __t, __p = '', __e = _.escape;
    with (obj) {
        __p += '<div class=\'fb-edit-section-header\'>Minimum / Maximum</div>\n\nAbove\n<input type="text" data-rv-input="model.' +
                ((__t = (Formbuilder.options.mappings.MIN)) == null ? '' : __t) +
                '" style="width: 30px" />\n\n&nbsp;&nbsp;\n\nBelow\n<input type="text" data-rv-input="model.' +
                ((__t = (Formbuilder.options.mappings.MAX)) == null ? '' : __t) +
                '" style="width: 30px" />\n';

    }
    return __p;
};

this["Formbuilder"]["templates"]["edit/min_max_length"] = function(obj) {
    obj || (obj = {});
    var __t, __p = '', __e = _.escape;
    with (obj) {
        __p += '<div class=\'fb-edit-section-header\'>Giới hạn độ dài</div>\n\nNhỏ nhất\n<input type="text" data-rv-input="model.' +
                ((__t = (Formbuilder.options.mappings.MINLENGTH)) == null ? '' : __t) +
                '" style="width: 30px" />\n\n&nbsp;&nbsp;\n\nLớn nhất\n<input type="text" data-rv-input="model.' +
                ((__t = (Formbuilder.options.mappings.MAXLENGTH)) == null ? '' : __t) +
                '" style="width: 30px" />\n\n&nbsp;&nbsp;\n\n';

    }
    return __p;
};

this["Formbuilder"]["templates"]["edit/options"] = function(obj) {
    obj || (obj = {});
    var __t, __p = '', __e = _.escape, __j = Array.prototype.join;
    function print() {
        __p += __j.call(arguments, '')
    }
    with (obj) {
        __p += '<div class=\'fb-edit-section-header\'>Tùy chọn</div>\n\n';
        if (typeof includeBlank !== 'undefined') {
            ;
            __p += '\n  <label>\n    <input type=\'checkbox\' data-rv-checked=\'model.' +
                    ((__t = (Formbuilder.options.mappings.INCLUDE_BLANK)) == null ? '' : __t) +
                    '\' />\n    Bao gồng rỗng\n  </label>\n';
        }
        ;
        __p += '\n\n<div class=\'option\' data-rv-each-option=\'model.' +
                ((__t = (Formbuilder.options.mappings.OPTIONS)) == null ? '' : __t) +
                '\'>\n  <input type="checkbox" class=\'js-default-updated\' data-rv-checked="option:checked" />\n  <input type="text" data-rv-input="option:label" placeholder="Tiêu đề" class=\'option-label-input\' /> <input type="text" placeholder="Giá trị" data-rv-input="option:value" class=\'option-value-input\' /> \n  <a class="js-add-option ' +
                ((__t = (Formbuilder.options.BUTTON_CLASS)) == null ? '' : __t) +
                '" title="Thêm tùy chọn"><i class=\'fa fa-plus-circle\'></i></a>\n  <a class="js-remove-option ' +
                ((__t = (Formbuilder.options.BUTTON_CLASS)) == null ? '' : __t) +
                '" title="Xóa tùy chọn"><i class=\'fa fa-minus-circle\'></i></a>\n</div>\n\n';
        if (typeof includeOther !== 'undefined') {
            ;
            __p += '\n  <label>\n    <input type=\'checkbox\' data-rv-checked=\'model.' +
                    ((__t = (Formbuilder.options.mappings.INCLUDE_OTHER)) == null ? '' : __t) +
                    '\' />\n    Bao gồm "khác"\n  </label>\n';
        }
        ;
        __p += '\n\n<div class=\'fb-bottom-add\'>\n  <a class="js-add-option ' +
                ((__t = (Formbuilder.options.BUTTON_CLASS)) == null ? '' : __t) +
                '">Thêm tùy chọn</a>\n</div>\n';

    }
    return __p;
};

this["Formbuilder"]["templates"]["edit/size"] = function(obj) {
    obj || (obj = {});
    var __t, __p = '', __e = _.escape;
    with (obj) {
        __p += '<div class=\'fb-edit-section-header\'>Cỡ</div>\n<select data-rv-value="model.' +
                ((__t = (Formbuilder.options.mappings.SIZE)) == null ? '' : __t) +
                '">\n  <option value="small">Nhỏ</option>\n  <option value="medium">Trung bình</option>\n  <option value="large">Lớn</option>\n</select>\n';

    }
    return __p;
};

this["Formbuilder"]["templates"]["edit/units"] = function(obj) {
    obj || (obj = {});
    var __t, __p = '', __e = _.escape;
    with (obj) {
        __p += '<div class=\'fb-edit-section-header\'>Units</div>\n<input type="text" data-rv-input="model.' +
                ((__t = (Formbuilder.options.mappings.UNITS)) == null ? '' : __t) +
                '" />\n';

    }
    return __p;
};

this["Formbuilder"]["templates"]["page"] = function(obj) {
    obj || (obj = {});
    var __t, __p = '', __e = _.escape;
    with (obj) {
        __p +=
                ((__t = (Formbuilder.templates['partials/save_button']())) == null ? '' : __t) +
                '\n' +
                ((__t = (Formbuilder.templates['partials/left_side']())) == null ? '' : __t) +
                '\n' +
                ((__t = (Formbuilder.templates['partials/right_side']())) == null ? '' : __t) +
                '\n<div class=\'fb-clear\'></div>';

    }
    return __p;
};

this["Formbuilder"]["templates"]["partials/add_field"] = function(obj) {
    obj || (obj = {});
    var __t, __p = '', __e = _.escape, __j = Array.prototype.join;
    function print() {
        __p += __j.call(arguments, '')
    }
    with (obj) {
        __p += '<div class=\'fb-tab-pane active\' id=\'addField\'>\n  <div class=\'fb-add-field-types\'>\n    <div class=\'section\'>\n      ';
        _.each(_.sortBy(Formbuilder.inputFields, 'order'), function(f) {
            ;
            __p += '\n        <div class="addfieldbutton"><a data-field-type="' +
                    ((__t = (f.field_type)) == null ? '' : __t) +
                    '" class="' +
                    ((__t = (Formbuilder.options.BUTTON_CLASS)) == null ? '' : __t) +
                    '">\n          ' +
                    ((__t = (f.addButton)) == null ? '' : __t) +
                    '\n        </a></div>\n      ';
        });
        ;
        __p += '\n    </div>\n\n    <div class=\'section\'>\n      ';
        _.each(_.sortBy(Formbuilder.nonInputFields, 'order'), function(f) {
            ;
            __p += '\n     <div class="addfieldbutton">   <a data-field-type="' +
                    ((__t = (f.field_type)) == null ? '' : __t) +
                    '" class="' +
                    ((__t = (Formbuilder.options.BUTTON_CLASS)) == null ? '' : __t) +
                    '">\n          ' +
                    ((__t = (f.addButton)) == null ? '' : __t) +
                    '\n        </a></div>\n      ';
        });
        ;
        __p += '\n    </div>\n  </div>\n</div>';

    }
    return __p;
};

this["Formbuilder"]["templates"]["partials/edit_field"] = function(obj) {
    obj || (obj = {});
    var __t, __p = '', __e = _.escape;
    with (obj) {
        __p += '<div class=\'fb-tab-pane\' id=\'editField\'>\n  <div class=\'fb-edit-field-wrapper\'></div>\n</div>\n';

    }
    return __p;
};

this["Formbuilder"]["templates"]["partials/left_side"] = function(obj) {
    obj || (obj = {});
    var __t, __p = '', __e = _.escape;
    with (obj) {
        __p += '<div class=\'fb-left\'>\n  <ul class=\'fb-tabs\'>\n    <li class=\'active\'><a data-target=\'#addField\'>Thêm trường mới</a></li>\n    <li><a data-target=\'#editField\'>Sửa</a></li>\n  </ul>\n\n  <div class=\'fb-tab-content\'>\n    ' +
                ((__t = (Formbuilder.templates['partials/add_field']())) == null ? '' : __t) +
                '\n    ' +
                ((__t = (Formbuilder.templates['partials/edit_field']())) == null ? '' : __t) +
                '\n  </div>\n</div>';

    }
    return __p;
};

this["Formbuilder"]["templates"]["partials/right_side"] = function(obj) {
    obj || (obj = {});
    var __t, __p = '', __e = _.escape;
    with (obj) {
//        __p += '<div class=\'fb-right\'>\n\
//                    <div class="item_basic_info"><div class="form-horizontal"> \n\
//                        <div class="inline">\n\
//                            <label>Item name</label> <div class="controls"> \n\
//                            <input type="text" class="itemname" placeholder="Item name" data-rv-input="model.item_name" value="'+
//                                Formbuilder.item['name']
//                            +'"></div> \n\
//                        </div>\n \n\
//                        <div class="inline">\n\
//                            <label>Item description</label> \n\
//                            <div class="controls"><textarea value="'+
//                             ((__t = (Formbuilder.fields[(Formbuilder.options.mappings.ITEM_DESCRIPTION)])) == null ? '' : __t) +
//                            '" class="itemdescription"></textarea></div>\n\
//                        </div> \
//                    </div>\n\
//                </div> \n' +
//            '<div class=\'fb-no-response-fields\'>No response fields</div>\n  <div class=\'fb-response-fields\'></div>\n</div>\n';
        __p += '<div class=\'fb-right\'>\n  <div class=\'fb-no-response-fields\' style="padding: 5px 0px;">Phải có ít nhất 1 trường trong form</div>\n  <div class=\'fb-response-fields\'></div>\n</div>\n';
    }
    return __p;
};

this["Formbuilder"]["templates"]["partials/save_button"] = function(obj) {
    obj || (obj = {});
    var __t, __p = '', __e = _.escape;
    with (obj) {
        __p += '<div class=\'fb-save-wrapper\'>\n  <button class=\'js-save-form ' +
                ((__t = (Formbuilder.options.BUTTON_CLASS)) == null ? '' : __t) +
                '\'></button>\n</div>';

    }
    return __p
};

this["Formbuilder"]["templates"]["view/base"] = function(obj) {
    obj || (obj = {});
    var __t, __p = '', __e = _.escape;
    with (obj) {
        __p += '<div class=\'subtemplate-wrapper\'>\n  <div class=\'cover\'></div>\n  ' +
                ((__t = (Formbuilder.templates['view/label']({rf: rf}))) == null ? '' : __t) +
                '\n\n  ' +
                ((__t = (Formbuilder.fields[rf.get(Formbuilder.options.mappings.FIELD_TYPE)].view({rf: rf}))) == null ? '' : __t) +
                '\n\n  ' +
                ((__t = (Formbuilder.templates['view/description']({rf: rf}))) == null ? '' : __t) +
                '\n  ' +
                ((__t = (Formbuilder.templates['view/duplicate_remove']({rf: rf}))) == null ? '' : __t) +
                '\n</div>\n';

    }
    return __p;
};

this["Formbuilder"]["templates"]["view/base_non_input"] = function(obj) {
    obj || (obj = {});
    var __t, __p = '', __e = _.escape;
    with (obj) {
        __p += '<div class=\'subtemplate-wrapper\'>\n  <div class=\'cover\'></div>\n  ' +
                ((__t = (Formbuilder.fields[rf.get(Formbuilder.options.mappings.FIELD_TYPE)].view({rf: rf}))) == null ? '' : __t) +
                '\n  ' +
                ((__t = (Formbuilder.templates['view/duplicate_remove']({rf: rf}))) == null ? '' : __t) +
                '\n</div>\n';

    }
    return __p;
};

this["Formbuilder"]["templates"]["view/description"] = function(obj) {
    obj || (obj = {});
    var __t, __p = '', __e = _.escape;
    with (obj) {
        __p += '<span class=\'help-block\'>\n  ' +
                ((__t = (Formbuilder.helpers.simple_format(rf.get(Formbuilder.options.mappings.DESCRIPTION)))) == null ? '' : __t) +
                '\n</span>\n';

    }
    return __p;
};

this["Formbuilder"]["templates"]["view/duplicate_remove"] = function(obj) {
    obj || (obj = {});
    var __t, __p = '', __e = _.escape;
    with (obj) {
        __p += '<div class=\'actions-wrapper\'>\n  <a class="js-duplicate ' +
                ((__t = (Formbuilder.options.BUTTON_CLASS)) == null ? '' : __t) +
                '" title="Duplicate Field"><i class=\'fa fa-plus-circle\'></i></a>\n  <a class="js-clear ' +
                ((__t = (Formbuilder.options.BUTTON_CLASS)) == null ? '' : __t) +
                '" title="Remove Field"><i class=\'fa fa-minus-circle\'></i></a>\n</div>';

    }
    return __p;
};

this["Formbuilder"]["templates"]["view/label"] = function(obj) {
    obj || (obj = {});
    var __t, __p = '', __e = _.escape, __j = Array.prototype.join;
    function print() {
        __p += __j.call(arguments, '')
    }
    with (obj) {
        __p += '<label>\n  <span>' +
                ((__t = (Formbuilder.helpers.simple_format(rf.get(Formbuilder.options.mappings.LABEL)))) == null ? '' : __t) +
                '\n  ';
        if (rf.get(Formbuilder.options.mappings.REQUIRED)) {
            ;
            __p += '\n    <abbr title=\'required\'>*</abbr>\n  ';
        }
        ;
        __p += '\n</label>\n';

    }
    return __p;
};

this["Formbuilder"]["templates"]["button/type"] = function(obj) {
    obj || (obj = {});
    var __t, __p = '', __e = _.escape;
    with (obj) {
        __p += '<div class="fb-edit-section-header">Loại nút</div><select class="changbttype" data-rv-value="model.' +
                ((__t = (Formbuilder.options.mappings.BUTTON_TYPE)) == null ? '' : __t) +
                '" style="width: auto;">\n <option value="click">Click</option><option value="submitform">Submit Form</option>\n\
                    <option value="cancelform">Cancel</option>\n\
                    <option value="resetform">Reset Form</option>\n</select>\n';
        __p += "<div class='buttonscript' style='" + ((obj.rf.get(Formbuilder.options.mappings.BUTTON_TYPE) == 'click') ? "" : "display: none;") + "'><div class='fb-edit-section-header'>Script</div><div class='fb-common-wrapper'><div class='fb-label-description'><textarea data-rv-input='model." + Formbuilder.options.mappings.ONCLICK + "' placeholder='Thêm script cho nút này'></textarea></div></div></div>";
    }
    return __p;
};


this["Formbuilder"]["templates"]["file/type"] = function(obj) {
    obj || (obj = {});
    var __t, __p = '', __e = _.escape;
    with (obj) {
        __p += '<div class="fb-edit-section-header">File type</div><select class="changbttype" data-rv-value="model.' +
                ((__t = (Formbuilder.options.mappings.FILE_TYPE)) == null ? '' : __t) +
                '" style="width: auto;">\n <option value="files">Files</option><option value="images">Images</option>\n</select>\n';
    }
    return __p;
};

// 
var fbuilder = {
    order: new Array(),
    listfields: {},
    autoincrement: 1,
    fieldcondition: '',
    getNewFormName: function() {
        var formname = 'form_' + this.autoincrement;
        this.autoincrement++;
        return formname;
    },
    getFieldCondition: function() {
        return this.fieldcondition;
    },
    setFieldCondition: function(con) {
        if (con) {
            this.fieldcondition = con;
        }
    },
    reset: function() {
        this.order = new Array();
    },
    getDateFormatText: function(val) {
        switch (val) {
            case 'mm/dd/yy':
                return 'Tháng/Ngày/Năm';
                break;
            case 'mm-dd-yy':
                return 'Tháng-Ngày-Năm';
                break;
            case 'dd/mm/yy':
                return 'Ngày/Tháng/Năm';
                break;
            case 'dd-mm-yy':
                return 'Ngày-Tháng-Năm';
                break;
        }
        return 'Ngày/Tháng/Năm';
    },
    getItemsData: function() {
        var listitem = {};
        jQuery.each(this.order, function(key, val) {
            listitem[val] = {};
            listitem[val]['fields'] = fbuilder.listfields[val].mainView.collection.toJSON();
        });
        return listitem;
    },
    validateItemData: function(data) {
        if (!data)
            return false;
        var ret = true;
        jQuery(".fb-main").find('.error').removeClass('error');
        jQuery(".fb-main").find('.errorMessage').hide();
        jQuery.each(data, function(key, val) {
            if (val['fields'].length <= 0) {
                jQuery('#' + key).find('.fb-right:first').addClass('error');
                ret = false;
            }
            if (!ret) {
                jQuery('#' + key).parents('.fb-main').find('a.showmore ').trigger('click');
                return;
            }
        });
        return ret;
    },
    getCountItemname: function(data, value) {
        var count = 0;
        if (!data)
            return count;
        jQuery.each(data, function(key, val) {
            if (val['info']['itemname'].toLocaleString() == value.toLocaleString()) {
                count++;
            }
        });
        return count;
    }
};
jQuery(document).on('click', 'a.showmore', function() {
    var fbmain = jQuery(this).closest('.fb-main');
    var showless = fbmain.find('.showless').show();
    //fbmain.find('.fbitem').show("slide", { direction: "right" }, 1000);
    fbmain.find('.fbitem').slideDown(500);
    jQuery(this).hide();
    return false;
});
jQuery(document).on('click', 'a.showless', function() {
    var fbmain = jQuery(this).closest('.fb-main');
    var showless = fbmain.find('.showmore').show();
    //fbmain.find('.fbitem').hide("slide", { direction: "right" }, 1000);
    fbmain.find('.fbitem').slideUp(600);
    jQuery(this).hide();
    return false;
});
jQuery(document).on('click', '.item_remove a.aitemremove', function() {
    if (fbuilder.order.length > 1) {
        if (confirm('Do you really want to delete this item?')) {
            var fbmain = $(this).closest('.fb-main');
            var fbname = fbmain.find('.fbname').val();
            var index = fbuilder.order.indexOf(fbname);
            fbuilder.order.splice(index, 1);
            fbmain.remove();
        }
    }
    return false;
});

jQuery(document).on('click', '.preview .iteminfo .itemhead', function() {
    var iteminfo = $(this).parents('.iteminfo');
    if (iteminfo.hasClass('show')) {
        iteminfo.removeClass('show');
        iteminfo.find('.itemfields').hide();
    } else {
        iteminfo.addClass('show');
        iteminfo.find('.itemfields').show();
    }
});

jQuery(document).ready(function() {
    jQuery('#savestep').on('click', function() {
        var thi = $(this);
        if (thi.hasClass('disable'))
            return false;
        thi.addClass('disable');
        var itemdata = fbuilder.getItemsData();
        var valid = fbuilder.validateItemData(itemdata);
        if (!valid) {
            thi.removeClass('disable');
            jQuery('html, body').animate({scrollTop: jQuery('.fb-main .error:first').offset().top - 30}, 1000);

        } else {
            $('#customform').submit();
            setTimeout(function() {
                thi.removeClass('disable');
            }, 300);
        }
        return false;
    });

    jQuery(document).on('submit', '#customform', function() {
        var thi = $(this);
        if (thi.hasClass('disable'))
            return false;
        thi.addClass('disable');
        //
        var itemdata = fbuilder.getItemsData();
        //
        var info = $(this).serialize() + '&itemdata=' + encodeURIComponent(JSON.stringify(itemdata));
        var href = $(this).attr('action');
        if (href) {
            jQuery.ajax({
                url: href,
                type: 'POST',
                dataType: 'JSON',
                data: info,
                success: function(res) {
                    switch (res.code) {
                        case 200:
                            {
                                if (res.redirect)
                                    window.location.href = res.redirect;
                                else
                                    window.location.href = window.location.href;
                            }
                            break;
                        default:
                            {
                                if (res.errors) {
                                    parseJsonErrors(res.errors, jQuery('#customform'));
                                    setTimeout(function() {
                                        console.log(jQuery('#customform .error:first').length);
                                        jQuery('html, body').animate({scrollTop: jQuery('#customform .errorMessage:first').offset().top - 30}, 1000);
                                    }, 1000);
                                }
                            }
                            break;

                    }
                    thi.removeClass('disable');
                },
                error: function() {
                    thi.removeClass('disable');
                }
            });
        } else
            thi.removeClass('disable');

        return false;
    });

    jQuery('#formpreview').on('click', function() {
        var itemdata = fbuilder.getItemsData();
        var valid = fbuilder.validateItemData(itemdata);
        if (!valid) {
            jQuery('html, body').animate({scrollTop: jQuery('.fb-main .error:first').offset().top - 30}, 1000);
        } else {
            var href = $(this).attr('href');
            if (href) {
                jQuery.ajax({
                    url: href,
                    type: 'POST',
                    //dataType: 'JSON',
                    data: {'itemdata': JSON.stringify(itemdata)},
                    success: function(res) {
                        $(document).LoPopUp({
                            title: 'Form preview',
                            clearBefore: true,
                            clearAfter: true,
                            maxwidth: '1000px',
                            minwidth: '1000px',
                            maxheight: '800px',
                            top: '100px',
                            contentHtml: res,
                        }
                        );
                        $(".LOpopup").show();
                    }
                });
            }
        }
        return false;
    });

    jQuery('#addnewitem').on('click', function() {
        var href = $(this).attr('href');
        jQuery.ajax({
            'url': href,
            'dataType': 'JSON',
            'success': function(res) {
                if (!res.error) {
                    $('body').append(res.html);
                }
            }
        });
        return false;
    });
});