Bookit.grid.Openschedule = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'bookit-grid-openschedule'
        ,url: Bookit.config.connectorUrl
        ,baseParams: { action: 'mgr/bookit/openschedule/getRows', idItem: MODx.request.id }
        ,fields: ['id', 'openDay','openFrom', 'openTo']
        ,paging: false
        ,remoteSort: true
        ,enableDragDrop: false
        ,anchor: '97%'
        ,autoExpandColumn: 'name'
        ,save_action: 'mgr/bookit/openschedule/updateFromGrid'
        ,autosave: true
        ,tbar:[{
           text: _('bookit.addOpenschedule')
           ,handler: { xtype: 'bookit-window-openschedule-add', blankValues: true }
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
    Bookit.grid.Openschedule.superclass.constructor.call(this,config)
};
Ext.extend(Bookit.grid.Openschedule,MODx.grid.Grid);
Ext.reg('bookit-grid-openschedule',Bookit.grid.Openschedule);

Bookit.window.NewOpenschedule = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'bookit-window-new-openschedule'
        ,title: _('bookit.addOpenschedule')
        ,url: Bookit.config.connectorUrl
        ,baseParams: {
            action: 'mgr/bookit/openschedule/addOpenschedule'
            ,idItem: MODx.request.id
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
    Bookit.window.NewOpenschedule.superclass.constructor.call(this,config);
};
Ext.extend(Bookit.window.NewOpenschedule,MODx.Window);
Ext.reg('bookit-window-openschedule-add',Bookit.window.NewOpenschedule);
