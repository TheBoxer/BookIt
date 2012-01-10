Bookit.panel.pricing = function(config) {
    config = config || {};
    Ext.apply(config,{
        border: false
        ,baseCls: 'modx-formpanel'
        ,items: [{
            html: '<h2><a href=\'index.php?a='+MODx.request.a+'\'>'+_('bookit')+'</a> :: '+ _('bookit.pricingList') + '</h2>'
            ,border: false
            ,cls: 'modx-page-header'
        },{
            xtype: 'modx-tabs'
            ,bodyStyle: 'padding: 10px'
            ,defaults: { border: false ,autoHeight: true }
            ,border: true
            ,items: [{
                title: _('bookit.pricingList')
                ,defaults: { autoHeight: true }
                ,items: [{
                    html: '<p>'+_('bookit.pricingList_management_desc')+'</p><br />'
                    ,border: false
                },{
                	xtype: 'bookit-grid-pricing'
     				,preventRender: true
                }]
            }]
        }]
    });
    Bookit.panel.pricing.superclass.constructor.call(this,config);
};
Ext.extend(Bookit.panel.pricing,MODx.Panel);
Ext.reg('bookit-panel-pricing',Bookit.panel.pricing);