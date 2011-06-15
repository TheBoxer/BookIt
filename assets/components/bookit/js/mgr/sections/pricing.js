Ext.onReady(function() {
    MODx.load({ xtype: 'bookit-page-pricing'});
});
 
Bookit.page.pricing = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        components: [{
            xtype: 'bookit-panel-pricing'
            ,renderTo: 'bookit-panel-pricing-div'
        }]
    });
    Bookit.page.pricing.superclass.constructor.call(this,config);
};
Ext.extend(Bookit.page.pricing,MODx.Component);
Ext.reg('bookit-page-pricing',Bookit.page.pricing);