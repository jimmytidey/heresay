//aparently ning doesn't use jQuery

heresay_jquery = document.createElement('script');
heresay_jquery.src = 'http://jqueryjs.googlecode.com/files/jquery-1.2.6.min.js';heresay_jquery.type = 'text/javascript';
document.getElementsByTagName('head')[0].appendChild(heresay_jquery);

//add our own custom script

heresay_script = document.createElement('script');
heresay_script.src = 'http://test.heresay.org.uk/platform/heresay_ning_test.js';
heresay_script.type = 'text/javascript';
document.getElementsByTagName('head')[0].appendChild(heresay_script);