Bookit.panel.Log = function(config) {
    config = config || {};
    Ext.apply(config,{
        border: false
        ,baseCls: 'modx-formpanel'
        ,items: [{
            html: '<h2>'+_('bookit.log')+'</h2>'
            ,border: false
            ,cls: 'modx-page-header'
        },{
            xtype: 'modx-tabs'
            ,bodyStyle: 'padding: 10px'
            ,defaults: { border: false ,autoHeight: true }
            ,border: true
            ,items: [{
                title: _('bookit.log')
                ,defaults: { autoHeight: true }
                ,items: [{
				   xtype: 'bookit-grid-log'
				   ,preventRender: true
				}]
            }]
        }]
    });
    Bookit.panel.Log.superclass.constructor.call(this,config);
};
Ext.extend(Bookit.panel.Log,MODx.Panel);
Ext.reg('bookit-panel-log',Bookit.panel.Log);