YUI.add('smile-tweethelper', function (Y) {
    Y.Handlebars.registerHelper('ifIn', function(param1, param2, options) {
        var ret = false;
        Y.each(param2, function(value) {
            if (param1 == value) {
                ret = true;
            }
        });
        if (ret) {
            return options.fn(this);
        }
        return options.inverse(this);
    });

    Y.Handlebars.registerHelper('ifEqual', function(param1, param2, options) {
        if (param1 == param2) {
            return options.fn(this);
        }
        return options.inverse(this);
    });
});
