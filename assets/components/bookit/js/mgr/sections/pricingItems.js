Ext.onReady(function() {
    MODx.load({ xtype: 'bookit-page-pricing-items'});
});
 
Bookit.page.PricingItems = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        components: [{
            xtype: 'bookit-panel-pricing-items'
            ,renderTo: 'bookit-panel-pricing-items-div'
        }]
    });
    Bookit.page.PricingItems.superclass.constructor.call(this,config);
};
Ext.extend(Bookit.page.PricingItems,MODx.Component);
Ext.reg('bookit-page-pricing-items',Bookit.page.PricingItems);