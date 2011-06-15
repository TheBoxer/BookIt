Bookit.grid.pricing = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'bookit-grid-openschedule'
        ,url: Bookit.config.connectorUrl
        ,baseParams: { action: 'mgr/bookit/pricing/getRows', openschedule_list: MODx.request.id}
        ,fields: ['id', 'name','description']
        ,paging: true
        ,remoteSort: true
        ,enableDragDrop: false
        ,anchor: '97%'
        ,autoExpandColumn: 'name'
        ,save_action: 'mgr/bookit/pricing/updateFromGrid'
        ,autosave: true
        ,tbar:[{
           text: _('bookit.addPriceList')
           ,handler: { xtype: 'bookit-window-pricing-list-new', blankValues: true }
        }]
        ,columns: [{
            header: _('bookit.name')
            ,width: 100
            ,dataIndex: 'name'
            ,sortable: false
            ,editor: { xtype: 'textfield', renderer: true}
        },{
            header: _('bookit.description')
            ,dataIndex: 'description'
            ,sortable: false
            ,editor: { xtype: 'textfield', renderer: true }
        }]
    });
    Bookit.grid.pricing.superclass.constructor.call(this,config)
};
Ext.extend(Bookit.grid.pricing,MODx.grid.Grid);
Ext.reg('bookit-grid-pricing',Bookit.grid.pricing);

Bookit.window.NewPricingList = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('bookit.addPriceList')
        ,url: Bookit.config.connectorUrl
        ,baseParams: {
            action: 'mgr/bookit/pricing/addPricing'
            ,openschedule_list: MODx.request.id
        }
        ,fields: [{
            xtype: 'textfield'
            ,fieldLabel: _('bookit.name')
            ,name: 'name'
            ,width: 300
        },{
            xtype: 'textarea'
            ,fieldLabel: _('bookit.description')
            ,name: 'description'
            ,width: 300
        }]
    });
    Bookit.window.NewPricingList.superclass.constructor.call(this,config);
};
Ext.extend(Bookit.window.NewPricingList,MODx.Window);
Ext.reg('bookit-window-pricing-list-new',Bookit.window.NewPricingList);

