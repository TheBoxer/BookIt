Bookit.grid.Log = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'bookit-grid-log'
        ,url: Bookit.config.connectorUrl
        ,baseParams: { action: 'mgr/bookit/log/getRows'}
        ,fields: ['id', 'type','customer', 'operator', 'price', 'day', 'hour', 'item', 'timeOfAction']
        ,paging: true
        ,enableDragDrop: false
        ,anchor: '97%'
        ,autoExpandColumn: 'name'
        ,tbar: [{
            xtype: 'bookit-extra-combo-log-type'
            ,id: 'bookit-log-filter-log-type'
            ,emptyText: _('bookit.select_log_type')
            ,listeners: {
                'select': {fn:this.filterLogType,scope:this}
            }
        },{
            xtype: 'bookit-extra-userlist-live'
            ,id: 'bookit-log-filter-user'
            ,emptyText: _('bookit.select_customer')
            ,listeners: {
                'select': {fn:this.filterUser,scope:this}
            }
        },{
            xtype: 'datefield'
            ,id: 'bookit-log-filter-date'
            ,emptyText: _('bookit.date')
            ,format: MODx.config.manager_date_format
            ,width: 120
            ,listeners: {
                'select': {fn:this.filterDay,scope:this}
            }
        },{
            xtype: 'timefield'
            ,id: 'bookit-log-filter-hour'
            ,emptyText: _('bookit.hour')
            ,format: MODx.config.manager_time_format
            ,increment: 80
            ,minValue: '06:00'
            ,width: 100
            ,listeners: {
                'select': {fn:this.filterHour,scope:this}
            }
        },{
            xtype: 'bookit-extra-combo-items'
            ,id: 'bookit-log-filter-item'
            ,emptyText: _('bookit.item')
            ,width: 100
            ,listeners: {
                'select': {fn:this.filterItem,scope:this}
            }
        },{
            xtype: 'bookit-extra-employees-live'
            ,id: 'bookit-log-filter-employees'
            ,emptyText: _('bookit.select_employee')
            ,listeners: {
                'select': {fn:this.filterEmployee,scope:this}
            }
        },{
            text: _('bookit.cancel_filter')
            ,handler: this.cancelFilter
        }]
        ,columns: [{
            header: _('bookit.type')
            ,width: 130
            ,dataIndex: 'type'
        },{
            header: _('bookit.customer')
            ,width: 100
            ,dataIndex: 'customer'
        },{
            header: _('bookit.day')
            ,width: 100
            ,dataIndex: 'day'
        },{
            header: _('bookit.hour')
            ,width: 80
            ,dataIndex: 'hour'
        },{
            header: _('bookit.item')
            ,width: 80
            ,dataIndex: 'item'
        },{
            header: _('bookit.price')
            ,width: 100
            ,dataIndex: 'price'
        },{
            header: _('bookit.operator')
            ,width: 100
            ,dataIndex: 'operator'
        },{
            header: _('bookit.time_of_action')
            ,width: 110
            ,dataIndex: 'timeOfAction'
        }]
    });
    Bookit.grid.Log.superclass.constructor.call(this,config)
};
Ext.extend(Bookit.grid.Log,MODx.grid.Grid,{
    filterUser: function(cb, nv, ov){
        this.getStore().setBaseParam('filterUser',cb.getValue());
        this.getBottomToolbar().changePage(1);
        this.refresh();
    }
    ,filterEmployee: function(cb, nv, ov){
        this.getStore().setBaseParam('filterEmployee',cb.getValue());
        this.getBottomToolbar().changePage(1);
        this.refresh();
    }
    ,filterLogType: function(cb, nv, ov){
        this.getStore().setBaseParam('filterLogType',cb.getValue());
        this.getBottomToolbar().changePage(1);
        this.refresh();
    }
    ,filterDay: function(cb, nv, ov){
        this.getStore().setBaseParam('filterDay',cb.getValue());
        this.getBottomToolbar().changePage(1);
        this.refresh();
    }
    ,filterHour: function(cb, nv, ov){
        this.getStore().setBaseParam('filterHour',cb.getValue());
        this.getBottomToolbar().changePage(1);
        this.refresh();
    }
    ,filterItem: function(cb, nv, ov){
        this.getStore().setBaseParam('filterItem',cb.getValue());
        this.getBottomToolbar().changePage(1);
        this.refresh();
    }
    ,cancelFilter: function(cb, nv, ov){
        Ext.getCmp('bookit-log-filter-user').reset();
        Ext.getCmp('bookit-log-filter-employees').reset();
        Ext.getCmp('bookit-log-filter-log-type').reset();
        Ext.getCmp('bookit-log-filter-date').reset();
        Ext.getCmp('bookit-log-filter-hour').reset();
        Ext.getCmp('bookit-log-filter-item').reset();
        this.getStore().setBaseParam('filterUser',null);
        this.getStore().setBaseParam('filterEmployee',null);
        this.getStore().setBaseParam('filterLogType',null);
        this.getStore().setBaseParam('filterDay',null);
        this.getStore().setBaseParam('filterHour',null);
        this.getStore().setBaseParam('filterItem',null);
        this.getBottomToolbar().changePage(1);
        this.refresh();
    }
});
Ext.reg('bookit-grid-log',Bookit.grid.Log);
