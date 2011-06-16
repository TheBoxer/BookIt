Bookit.panel.PricingItems = function(config) {
    config = config || {};
    Ext.apply(config,{
        border: false
        ,baseCls: 'modx-formpanel'
        ,url: Bookit.config.connectorUrl
        ,baseParams: {}
        ,items: [{
            html: '<h2><a href=\'index.php?a='+MODx.action['controllers/index']+'\'>'+_('bookit')+'</a> :: '+ _('bookit.pricingItems') +'</h2>'
            ,border: false
            ,cls: 'modx-page-header'
        },{
            xtype: 'modx-tabs'
            ,bodyStyle: 'padding: 10px'
            ,defaults: { border: false ,autoHeight: true }
            ,border: true
            ,items: [{
                title: _('bookit.pricingItems')
                ,layout: 'form'
                ,defaults: { autoHeight: true }
                ,items: [{
                	html: '<p>'+_('bookit.pricingItems_desc')+'</p>'
                	,border: false                    
                },{                    
                	id: 'bookit-pricing-items-noprice'
                	,html: '<p></p>'
                },{
                	xtype: 'bookit-grid-pricing-items'
                	,preventRender: true
                }]
            }]
        }]
	    ,listeners: {
	        'setup': {fn:this.setup,scope:this}
	    }
	    
    });
    Bookit.panel.PricingItems.superclass.constructor.call(this,config);
};
Ext.extend(Bookit.panel.PricingItems,MODx.FormPanel, {
	setup: function() {
        MODx.Ajax.request({
            url: this.config.url
            ,params: {
                action: 'mgr/bookit/pricing/items/getNoPrice'
                ,id: MODx.request.id
            }
	        ,listeners: {
	            'success': {fn:function(r) {
	                this.getForm().setValues(r.object);
	
	                Ext.getCmp('bookit-pricing-items-noprice').getEl().update('<p><b>'+ _('bookit.openschedule') +'</b></p>'+r.object.noPrice);
	            },scope:this}
	        }
        });
    }
});
Ext.reg('bookit-panel-pricing-items',Bookit.panel.PricingItems);