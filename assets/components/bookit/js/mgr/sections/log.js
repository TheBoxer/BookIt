Ext.onReady(function() {
    MODx.load({ xtype: 'bookit-page-log'});
});
 
Bookit.page.Log = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        components: [{
            xtype: 'bookit-panel-log'
            ,renderTo: 'bookit-panel-log-div'
        }]
    });
    Bookit.page.Log.superclass.constructor.call(this,config);
};
Ext.extend(Bookit.page.Log,MODx.Component);
Ext.reg('bookit-page-log',Bookit.page.Log);