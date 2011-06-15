Ext.onReady(function() {
    MODx.load({ xtype: 'bookit-page-openschedule'});
});
 
Bookit.page.OpenSchedule = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        components: [{
            xtype: 'bookit-panel-openschedule-items'
            ,renderTo: 'bookit-panel-openschedule-items-div'
        }]
    });
    Bookit.page.OpenSchedule.superclass.constructor.call(this,config);
};
Ext.extend(Bookit.page.OpenSchedule,MODx.Component);
Ext.reg('bookit-page-openschedule',Bookit.page.OpenSchedule);