Bookit.grid.Pricing = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'bookit-grid-pricing'
        ,url: Bookit.config.connectorUrl
        ,baseParams: { action: 'mgr/bookit/openschedule/getPricingRows', idItem: MODx.request.id }
        ,fields: ['id', 'openDay','priceFrom', 'priceTo', 'price']
        ,paging: true
        ,remoteSort: true
        ,enableDragDrop: false
        ,anchor: '97%'
        ,autoExpandColumn: 'name'
        ,save_action: 'mgr/bookit/openschedule/updateFromGrid'
        ,saveParams: { idItem: MODx.request.id}
        ,autosave: true
        ,tbar:[{
           text: _('bookit.addPrice')
           ,handler: { xtype: 'bookit-window-openschedule-add', blankValues: true }
        },'-','-','-','-',{
            xtype: 'bookit-extra-combo-day'
            ,id: 'bookit-openschedule-pricing-filter-day'
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
        ,getMenu: function() {
            var m = [{
                text: _('bookit.openschedule_delete')
                ,handler: this.removeOpenschedule
            }];
            this.addContextMenuItem(m);
            return true;
        }
        ,removeOpenschedule: function(btn,e) {
            MODx.msg.confirm({ 
                title: _('bookit.openschedule_delete') 
                ,text: _('bookit.openschedule_delete_confirm') 
                ,url: this.config.url 
                ,params: { 
                    action: 'mgr/bookit/openschedule/remove'
                    ,id: this.menu.record.id
                } 
                ,listeners: { 
                    'success': {fn:this.refresh,scope:this} 
                } 
            });
        }
        ,columns: [{
            header: _('bookit.day')
            ,dataIndex: 'openDay'
            ,sortable: false
            ,editor: { xtype: 'bookit-extra-combo-day', renderer: true}
        },{
            header: _('bookit.priceFrom')
            ,dataIndex: 'priceFrom'
            ,sortable: false
            ,width: 90
            ,editor: { xtype: 'timefield', format: MODx.config.manager_time_format, renderer: true }
        },{
            header: _('bookit.priceTo')
            ,dataIndex: 'priceTo'
            ,sortable: false
            ,width: 90
            ,editor: { xtype: 'timefield', format: MODx.config.manager_time_format, renderer: true }
        },{
            header: _('bookit.price')
            ,dataIndex: 'price'
            ,sortable: false
            ,width: 90
            ,editor: { xtype: 'textfield'}
        }]
    });
    Bookit.grid.Pricing.superclass.constructor.call(this,config)
};
Ext.extend(Bookit.grid.Pricing,MODx.grid.Grid,{
    filterDay: function(cb,nv,ov) {
        this.getStore().setBaseParam('filterDay',cb.getValue());
        this.getBottomToolbar().changePage(1);
        this.refresh();
    }
    ,clearFilter: function() {
        this.getStore().baseParams = {
            action: 'mgr/bookit/openschedule/getRows'
            ,idItem: MODx.request.id
        };
        Ext.getCmp('bookit-openschedule-pricing-filter-day').reset();
        this.getBottomToolbar().changePage(1);
        this.refresh();
    }
    
});
Ext.reg('bookit-grid-pricing',Bookit.grid.Pricing);
