Ext.onReady(function() {
    MODx.load({ xtype: 'bookit-page-settings'});
});
 
Bookit.page.Settings = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        components: [{
            xtype: 'bookit-panel-settings'
            ,renderTo: 'bookit-panel-settings-div'
        }]
    });
    Bookit.page.Settings.superclass.constructor.call(this,config);
};
Ext.extend(Bookit.page.Settings,MODx.Component);
Ext.reg('bookit-page-settings',Bookit.page.Settings);