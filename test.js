var page = new WebPage(),
    address, output, size;
 var retval = {};
retval.result = "failed";
retval.messages = [];

//capture and captureSelector functions adapted from CasperJS - https://github.com/n1k0/casperjs
capture = function(targetFile, clipRect) {

    try {
        page.render(targetFile);
    } catch (e) {
      return false;
	}
    return this;
};

captureSelector = function(targetFile, selector) {
    return capture(targetFile, page.evaluate(function(selector) {
        try {
            var clipRect = document.querySelector(selector).getBoundingClientRect();
            return {
                top: clipRect.top,
                left: clipRect.left,
                width: clipRect.width,
                height: clipRect.height
            };
        } catch (e) {

        }
    }, { selector: selector }));
};

if (phantom.args.length < 3) {
    //console.log('Usage: test2.js buttons.html .selector_class outputname');
    retval.messages.push("3 arguments required.");
    console.log(JSON.stringify(retval,undefined,4));
    phantom.exit();
} else {
    address = phantom.args[0];
    page.customHeaders = {'Referer': "www.invitestack.com"};
    page.viewportSize = { width: 1, height: 1 };
    page.paperSize = { width: 1, height: 1, border: '0px' };
    page.open(address, function (status) {
        if (status !== 'success') {
            console.log('Unable to load the address!');
        } else
        {
          //console.log(phantom.args[1]);
           //dump out each icon in buttons.html as individual png file
           var outputfile = phantom.args[2];
           if(captureSelector(outputfile,phantom.args[1])){
            retval['result'] = "success";
            retval['filename'] = outputfile;
            console.log(JSON.stringify(retval,undefined,4));
           }
           else{
	   	}
            phantom.exit();
      }
    });
}