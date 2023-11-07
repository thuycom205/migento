define(['jquery','jquery-ui-modules/widget', 'Magento_Ui/js/modal/modal'], function ($) {
    $.widget('xseed.xpopup', {
        options: {
            // Configure your popup options here
        },
        _create: function () {
            var self = this;
            alert("hello world from widget");
            console.log('Thuy popup');
            setInterval(function () {
                self._openPopup();
            }, 30000);
        },
        _openPopup: function () {
            // Code to open the popup goes here
            // You can use Magento UI modal or a custom popup method
        }
    });
    return $.xseed.xpopup;
});
