Bookit.grid.PricingItems = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'bookit-grid-pricing-items'
        ,url: Bookit.config.connectorUrl
        ,baseParams: { action: 'mgr/bookit/pricing/items/getRows', pricing_list: MODx.request.id }
        ,fields: ['id', 'priceDay','priceFrom', 'priceTo', 'price']
        ,paging: true
        ,remoteSort: true
        ,enableDragDrop: false
        ,anchor: '97%'
        ,autoExpandColumn: 'name'
        ,save_action: 'mgr/bookit/pricing/items/updateFromGrid'
        ,saveParams: { pricing_list: MODx.request.id}
        ,autosave: true
        ,tbar:[{
           text: _('bookit.addPrice')
           ,handler: { xtype: 'bookit-window-pricing-item-add', blankValues: true }
        },'-','-','-','-',{
            xtype: 'bookit-extra-combo-day'
            ,id: 'bookit-pricing-item-filter-day'
            ,emptyText: _('bookit.select_day')
            ,listeners: {
                'select': {fn:this.filterDay,scope:this}
            }
        },{
            xtype: 'button'
            ,text: _('bookit.clear_filter')
            ,listeners: {
                'click': {fn: this.clearFilter, scope: this}
            }
        }]
        ,columns: [{
            header: _('bookit.day')
            ,dataIndex: 'priceDay'
            ,sortable: false
            ,editor: { xtype: 'bookit-extra-combo-day', renderer: true}
        },{
            header: _('bookit.priceFrom')
            ,dataIndex: 'priceFrom'
            ,sortable: false
            ,width: 90
            ,editor: { xtype: 'timefield', format: MODx.config.manager_time_format, increment: 60 }
        },{
            header: _('bookit.priceTo')
            ,dataIndex: 'priceTo'
            ,sortable: false
            ,width: 90
            ,editor: { xtype: 'timefield', format: MODx.config.manager_time_format, increment: 60 }
        },{
            header: _('bookit.price')
            ,dataIndex: 'price'
            ,sortable: false
            ,width: 90
            ,editor: { xtype: 'numberfield', renderer: true }
        }]
    });
    Bookit.grid.PricingItems.superclass.constructor.call(this,config)
};
Ext.extend(Bookit.grid.PricingItems,MODx.grid.Grid, {
	getMenu: function() {
        var m = [{
            text: _('bookit.pricingItem_delete')
            ,handler: this.removePricingItem
        }];
        this.addContextMenuItem(m);
        return true;
    }
    ,removePricingItem: function(btn,e) {
        MODx.msg.confirm({ 
            title: _('bookit.pricingItem_delete') 
            ,text: _('bookit.pricingItem_delete_confirm') 
            ,url: this.config.url 
            ,params: { 
                action: 'mgr/bookit/pricing/items/removeRow'
                ,id: this.menu.record.id
            } 
            ,listeners: { 
                'success': {fn:this.refresh,scope:this} 
            } 
        });
    }
    ,filterDay: function(cb,nv,ov) {
        this.getStore().setBaseParam('filterDay',cb.getValue());
        this.getBottomToolbar().changePage(1);
        this.refresh();
    }
    ,clearFilter: function() {
        this.getStore().baseParams = {
            action: 'mgr/bookit/pricing/items/getRows'
            ,pricing_list: MODx.request.id
        };
        Ext.getCmp('bookit-pricing-item-filter-day').reset();
        this.getBottomToolbar().changePage(1);
        this.refresh();
    }
});
Ext.reg('bookit-grid-pricing-items',Bookit.grid.PricingItems);

Bookit.window.NewPricingItem = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'bookit-window-pricing-item-add'
        ,title: _('bookit.addPrice')
        ,url: Bookit.config.connectorUrl
        ,baseParams: {
            action: 'mgr/bookit/pricing/items/addPricingItem'
            ,pricing_list: MODx.request.id
        }
        ,fields: [{
            xtype: 'bookit-extra-combo-day'
            ,focus: true
            ,fieldLabel: _('bookit.day')
            ,name: 'priceDay'
            ,width: 300
        },{
            xtype: 'timefield'
            ,format: MODx.config.manager_time_format
            ,fieldLabel: _('bookit.priceFrom')
            ,name: 'priceFrom'
            ,increment: 60
            ,width: 300
        },{
            xtype: 'timefield'
            ,format: MODx.config.manager_time_format
            ,fieldLabel: _('bookit.priceTo')
            ,name: 'priceTo'
            ,increment: 60
            ,width: 300
        },{
            xtype: 'numberfield'
                ,fieldLabel: _('bookit.price')
                ,name: 'price'
                ,width: 300
            }]
    });
    Bookit.window.NewPricingItem.superclass.constructor.call(this,config);
};
Ext.extend(Bookit.window.NewPricingItem,MODx.Window);
Ext.reg('bookit-window-pricing-item-add',Bookit.window.NewPricingItem);
