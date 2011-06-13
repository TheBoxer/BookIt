Ext.onReady(function() {
    MODx.load({ xtype: 'bookit-page-openschedule'});
});
 
Bookit.page.Openschedule = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        components: [{
            xtype: 'bookit-panel-openschedule'
            ,renderTo: 'bookit-panel-openschedule-div'
        }]
    });
    Bookit.page.Openschedule.superclass.constructor.call(this,config);
};
Ext.extend(Bookit.page.Openschedule,MODx.Component);
Ext.reg('bookit-page-openschedule',Bookit.page.Openschedule);