<?php
$model = new Push_Model_Onesignal();
$model->loadOptions($options);
?>
<link rel="manifest" href="/manifest.json" />
<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async='async'></script>
<script>
    var OneSignal = window.OneSignal || [];
    OneSignal.push(["init", {
            appId: "<?php echo $model->app_id ?>",
            autoRegister: true, /* Set to true to automatically prompt visitors */
            subdomainName: '<?php echo $model->subDomainName; ?>',
            notifyButton: {
                enable: true,
                size: 'medium',
                position: 'bottom-right',
                prenotify: true,
                showCredit: false,
                text: {
                    'tip.state.unsubscribed': '<?php echo $model->tipStateUnsubscribed ?>',
                    'tip.state.subscribed': '<?php echo $model->tipStateSubscribed ?>',
                    'tip.state.blocked': '<?php echo $model->tipStateBlocked ?>',
                    'message.prenotify': '<?php echo $model->messagePrenotify ?>',
                    'message.action.subscribed': '<?php echo $model->messageActionSubscribed ?>',
                    'message.action.resubscribed': '<?php echo $model->messageActionResubscribed ?>',
                    'message.action.unsubscribed': '<?php echo $model->messageActionUnsubscribed ?>',
                    'dialog.main.title': '<?php echo $model->dialogMainTitle ?>',
                    'dialog.main.button.subscribe': '<?php echo $model->dialogMainButtonSubscribe ?>',
                    'dialog.main.button.unsubscribe': '<?php echo $model->dialogMainButtonUnsubscribe ?>',
                    'dialog.blocked.title': '<?php echo $model->dialogBlockedTitle ?>',
                    'dialog.blocked.message': '<?php echo $model->dialogBlockedMessage ?>'
                }
            },
            welcomeNotification: {
                title: '<?php echo $model->title ?>',
                message: '<?php echo $model->message ?>'
            },
            promptOptions: {
                siteName: '<?php echo $model->site_name ?>',
                actionMessage: '<?php echo $model->actionMessage ?>',
                exampleNotificationTitle: '<?php echo $model->exampleNotificationTitle ?>',
                exampleNotificationMessage: '<?php echo $model->exampleNotificationMessage ?>',
                exampleNotificationCaption: '<?php echo $model->exampleNotificationCaption ?>',
                acceptButtonText: '<?php echo $model->acceptButtonText ?>',
                cancelButtonText: '<?php echo $model->cancelButtonText ?>'
            }
        }]);
    jQuery(function () {
        OneSignal.push(function () {
            OneSignal.on('subscriptionChange', function (isSubscribed) {
                if (isSubscribed) {
                    // The user is subscribed
                    //   Either the user subscribed for the first time
                    //   Or the user was subscribed -> unsubscribed -> subscribed
                    OneSignal.getUserId(function (userId) {
                        // Make a POST call to your server with the user ID
                    });
                }
            });
            OneSignal.getUserId(function (userId) {
                console.log("OneSignal User ID:", userId);
            });
        });
    });
</script>