Bookit.panel.Home = function(config) {
    config = config || {};
    Ext.apply(config,{
        border: false
        ,baseCls: 'modx-formpanel'
        ,items: [{
            html: '<h2>'+_('bookit')+'</h2>'
            ,border: false
            ,cls: 'modx-page-header'
        },{
            xtype: 'modx-tabs'
            ,bodyStyle: 'padding: 10px'
            ,defaults: { border: false ,autoHeight: true }
            ,border: true
            ,items: [{
                title: _('bookit')
                ,defaults: { autoHeight: true }
                ,items: [{
                    html: '<p>'+_('bookit.management_desc')+'</p><br />'
                    ,border: false
                }]
            },{
                title: _('bookit.item_managment')
                ,defaults: { autoHeight: true }
                ,items: [{
                    html: '<p>'+_('bookit.item_management_desc')+'</p><br />'
                    ,border: false
                },{
				   xtype: 'bookit-grid-items'
				   ,preventRender: true
				}]
            }]
        }]
    });
    Bookit.panel.Home.superclass.constructor.call(this,config);
};
Ext.extend(Bookit.panel.Home,MODx.Panel);
Ext.reg('bookit-panel-home',Bookit.panel.Home);