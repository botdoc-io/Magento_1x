function openBotDocPopup(url) {
    if ($('browser_window') && typeof(Windows) != 'undefined') {
        Windows.focus('browser_window');
        return;
    }
    var dialogWindow = Dialog.info(null, {
        closable:true,
        resizable:false,
        draggable:true,
        className:'magento',
        windowClassName:'popup-window',
        title:'BotDoc - Send Request',
        top:80,
        width:450,
        height:150,
        zIndex:1000,
        recenterAuto:false,
        hideEffect:Element.hide,
        showEffect:Element.show,
        id:'browser_window',
        url:url,
        onClose:function (param, el) {
            
        }
    });
}

function closeBotDocPopup() {
    Windows.close('browser_window');
}