Ext.onReady(function() {
    MODx.load({ xtype: 'bookit-page-openschedule-items'});
});
 
Bookit.page.OpenScheduleItems = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        components: [{
            xtype: 'bookit-panel-openschedule-items'
            ,renderTo: 'bookit-panel-openschedule-items-div'
        }]
    });
    Bookit.page.OpenScheduleItems.superclass.constructor.call(this,config);
};
Ext.extend(Bookit.page.OpenScheduleItems,MODx.Component);
Ext.reg('bookit-page-openschedule-items',Bookit.page.OpenScheduleItems);