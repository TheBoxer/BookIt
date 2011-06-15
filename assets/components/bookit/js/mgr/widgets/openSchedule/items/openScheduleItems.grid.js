Bookit.grid.OpenScheduleItems = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'bookit-grid-openschedule-items'
        ,url: Bookit.config.connectorUrl
        ,baseParams: { action: 'mgr/bookit/openSchedule/items/getRows', idItem: MODx.request.id }
        ,fields: ['id', 'openDay','openFrom', 'openTo']
        ,paging: true
        ,remoteSort: true
        ,enableDragDrop: false
        ,anchor: '97%'
        ,autoExpandColumn: 'name'
        ,save_action: 'mgr/bookit/openSchedule/items/updateFromGrid'
        ,saveParams: { openschedule_list: MODx.request.id}
        ,autosave: true
        ,tbar:[{
           text: _('bookit.addOpenschedule')
           ,handler: { xtype: 'bookit-window-openschedule-item-add', blankValues: true }
        },'-','-','-','-',{
            xtype: 'bookit-extra-combo-day'
            ,id: 'bookit-openschedule-item-filter-day'
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
            ,dataIndex: 'openDay'
            ,sortable: false
            ,editor: { xtype: 'bookit-extra-combo-day', renderer: true}
        },{
            header: _('bookit.openFrom')
            ,dataIndex: 'openFrom'
            ,sortable: false
            ,width: 90
            ,editor: { xtype: 'timefield', format: MODx.config.manager_time_format, renderer: true }
        },{
            header: _('bookit.openTo')
            ,dataIndex: 'openTo'
            ,sortable: false
            ,width: 90
            ,editor: { xtype: 'timefield', format: MODx.config.manager_time_format, renderer: true }
        }]
    });
    Bookit.grid.OpenScheduleItems.superclass.constructor.call(this,config)
};
Ext.extend(Bookit.grid.OpenScheduleItems,MODx.grid.Grid,{
    getMenu: function() {
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
                action: 'mgr/bookit/openSchedule/items/removeRow'
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
            action: 'mgr/bookit/openSchedule/items/getRows'
            ,idItem: MODx.request.id
        };
        Ext.getCmp('bookit-openschedule-item-filter-day').reset();
        this.getBottomToolbar().changePage(1);
        this.refresh();
    }
    
});
Ext.reg('bookit-grid-openschedule-items',Bookit.grid.OpenScheduleItems);

Bookit.window.NewOpenScheduleItem = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'bookit-window-openschedule-item-add'
        ,title: _('bookit.addOpenschedule')
        ,url: Bookit.config.connectorUrl
        ,baseParams: {
            action: 'mgr/bookit/openSchedule/items/addOpenScheduleItem'
            ,openschedule_list: MODx.request.id
        }
        ,fields: [{
            xtype: 'bookit-extra-combo-day'
            ,focus: true
            ,fieldLabel: _('bookit.day')
            ,name: 'openDay'
            ,width: 300
        },{
            xtype: 'timefield'
            ,format: MODx.config.manager_time_format
            ,fieldLabel: _('bookit.openFrom')
            ,name: 'openFrom'
            ,width: 300
        },{
            xtype: 'timefield'
            ,format: MODx.config.manager_time_format
            ,fieldLabel: _('bookit.openTo')
            ,name: 'openTo'
            ,width: 300
        }]
    });
    Bookit.window.NewOpenScheduleItem.superclass.constructor.call(this,config);
};
Ext.extend(Bookit.window.NewOpenScheduleItem,MODx.Window);
Ext.reg('bookit-window-openschedule-item-add',Bookit.window.NewOpenScheduleItem);
