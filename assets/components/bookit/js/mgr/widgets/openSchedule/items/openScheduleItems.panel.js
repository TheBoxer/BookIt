Bookit.panel.OpenScheduleItems = function(config) {
    config = config || {};
    Ext.apply(config,{
        border: false
        ,baseCls: 'modx-formpanel'
        ,items: [{
            html: '<h2><a href=\'index.php?a='+MODx.action['controllers/index']+'\'>'+_('bookit')+'</a> :: '+ _('bookit.openschedule') +'</h2>'
            ,border: false
            ,cls: 'modx-page-header'
        },{
            xtype: 'modx-tabs'
            ,bodyStyle: 'padding: 10px'
            ,defaults: { border: false ,autoHeight: true }
            ,border: true
            ,items: [{
                title: _('bookit.openschedule')
                ,defaults: { autoHeight: true }
                ,items: [{
                    html: '<p>'+_('bookit.openschedule_desc')+'</p><br />'
                    ,border: false                    
                },{
                   xtype: 'bookit-grid-openschedule-items'
                   ,preventRender: true
                }]
            }]
        }]
    });
    Bookit.panel.OpenScheduleItems.superclass.constructor.call(this,config);
};
Ext.extend(Bookit.panel.OpenScheduleItems,MODx.Panel);
Ext.reg('bookit-panel-openschedule-items',Bookit.panel.OpenScheduleItems);