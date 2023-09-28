<style>
    .sortable { list-style-type: none; margin: 0; padding: 0; width: 100%; } 
    .sortable li { border: 2px solid #eeeeee; margin: 0px 15px 15px 0; padding: 1px; float: left; width: 200px; height: 210px; text-align: center;}
    .algalley .alimgbox .alimglist .alimgitem { width: 100%; }
    .algalley .alimgbox .alimglist .alimgitem .alimgitembox{ height: 200px; position: relative; }
    .algalley .alimgbox .alimglist .alimgitem .alimgaction{ position: absolute; bottom: 0px; }
    .algalley .alimgbox .alimglist .alimgitem .alimgthum { width: 200px; height: 200px; overflow: hidden; position: relative; }
    .algalley .alimgbox .alimglist .alimgitem .alimgthum img{ max-width: 185px; max-height: 185px; position: absolute; margin: auto; top: 0; bottom: 0; right: 0; left: 0; }
    .algalley .alimgbox .alimglist .alimgitem .alimgitembox .new_delimgaction_color{ color: red; font-size: 18px; position: absolute; display: none; top: 0px; right: 5px; z-index: 9; }
    .algalley .alimgbox .alimglist li:hover .alimgitem .alimgitembox .new_delimgaction_color{ display: block; }
    .algalley .alimgbox .alimglist .alimgitem .alimgitembox .delimgaction_color{ color: red; font-size: 18px; position: absolute; display: none; top: 0px; right: 5px; z-index: 9; }
    .algalley .alimgbox .alimglist li:hover .alimgitem .alimgitembox .delimgaction_color{ display: block; }
    .algalley .alimgbox .alimglist .alimgitem .alimgitembox .delimgaction{ color: red; font-size: 18px; position: absolute; display: none; top: 0px; right: 5px; z-index: 9; }
    .algalley .alimgbox .alimglist li:hover .alimgitem .alimgitembox .delimgaction{ display: block; }
    #product-attributes-cf .cf-row{
        padding: 5px 10px;
        margin-top: 0px;
    }
    #product-attributes-cf .action i{
        color: red;
    }
    #sortable .ui-state-default{
        float: left;
        list-style: none;
    }
    #algalley .alimgbox .alimglist .alimgitem .alimgitembox{
        width: 220px;
        margin-right: 20px;
        overflow: hidden;
    }
    .imgBox{display: inline;}
    #algalley .alimgbox .alimglist .alimgitem .alimgitembox .delimg{z-index: 100; background-color: transparent;}
    #algalley .alimgbox .alimglist .alimgitem .alimgitembox .delimg a.show-tag-action{margin-right: 40px; cursor: pointer;}
    #algalley .alimgbox .alimglist .alimgitem .alimgitembox .delimg a.embed-action{margin-right: 20px; cursor: pointer; display: none;}
    #algalley .alimgbox .alimglist .show-tag .alimgitem .alimgitembox .delimg a.embed-action{display: block;}
    #algalley .alimgbox .alimglist .show-tag{ width: 100%;}
    #algalley .alimgbox .alimglist .show-tag .alimgitem{width: 100%;}
    #algalley .alimgbox .alimglist .show-tag .alimgitem .alimgitembox{width: 100%; overflow: visible;}
    #algalley .alimgbox .alimglist .show-tag .alimgitem img{width: auto;}
    .algalley .alimgbox .alimglist .show-tag .alimgitem .alimgthum{width: 100%; height: auto;}
    .algalley .alimgbox .alimglist .show-tag .alimgitem .alimgitembox{height: auto; max-height: 100%; overflow: visible;}
    .algalley .alimgbox .alimglist .show-tag .alimgitem .alimgthum img{position: relative; max-width: 100%; max-height: 800px;}
    #algalley .alimgbox .alimglist .show-tag .alimgitem .alimgitembox .alimgthum{margin: 0px; overflow: visible;}
    .imageTagBox{position: absolute; width: 28px; height: 28px; display: none;}
    .show-tag .imageTagBox{display: block;}
    .imageTagBox .imgTag{color: #fff; font-size: 25px; position: absolute; padding: 5px; display: flex; top: -6px; left: -6px;}
    .imageTagBox .imageTagAction{position: absolute; top: -20px; right: -10px; display: none; padding: 5px; z-index: 10; font-size: 16px; }
    .imageTagBox .imageTagAction a{color: red;}
    .imageTagBox:hover .imageTagAction{display: block;}
    .imageTagBox .imageTagAction.edit{left: -30px; right: initial;}
    .imageTagBox .imageTagAction.edit a{color: #0000ff;}
    .imageTagProduct {position: absolute; left:30px; min-width: 400px; z-index: 11;}
    .imageTagProduct .itpBody{max-height: 400px; overflow-y: auto; overflow-x: hidden;}
    .imageTagProduct .iconConect{color: #fff; position: absolute; font-size: 16px; left: -5px}
    .imageTagProduct .iconHide{position: absolute;right: -10px;z-index: 100;padding: 5px;font-size: 16px;top: -14px;color: red;}
</style>