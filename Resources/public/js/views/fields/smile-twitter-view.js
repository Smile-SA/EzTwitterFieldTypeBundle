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
            return Y.JSON.parse(this.get('field').fieldValue);
        },
    });

    Y.eZ.FieldView.registerFieldView('smiletwitter', Y.Smile.TwitterView);
});
