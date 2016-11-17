YUI.add('smile-twitter-view', function (Y) {
    "use strict";
    Y.namespace('Smile');

    Y.Smile.TwitterView = Y.Base.create('twitterView', Y.eZ.FieldView, [], {
        _isFieldEmpty: function () {
            return (this.get('field').fieldValue === null);
        },

        _getName: function () {
            return Y.Smile.TwitterView.NAME;
        },

        /****/

        _getFieldValue: function () {
            var values = Y.JSON.parse(this.get('field').fieldValue);
            if (values == null) {
                values = { type: '' };
            } else if (values.type == null) {
                values.type = '';
            }
            return values;
        },
    });

    Y.eZ.FieldView.registerFieldView('smiletwitter', Y.Smile.TwitterView);
});
