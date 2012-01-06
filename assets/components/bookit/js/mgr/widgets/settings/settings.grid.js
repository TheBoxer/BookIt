Bookit.grid.settings = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'bookit-grid-settings'
        ,url: Bookit.config.connectorUrl
        ,baseParams: { action: 'mgr/bookit/settings/getRows'}
        ,fields: ['id', 'key','value']
        ,paging: true
        ,remoteSort: true
        ,enableDragDrop: false
        ,anchor: '97%'
        ,autoExpandColumn: 'name'
        ,save_action: 'mgr/bookit/settings/updateFromGrid'
        ,autosave: true
        ,tbar:[{
           text: _('bookit.addNewSetting')
           ,handler: { xtype: 'bookit-window-settings-new', blankValues: true }
        }]
        ,columns: [{
            header: _('bookit.settings_key')
            ,width: 100
            ,dataIndex: 'key'
            ,sortable: false
        },{
            header: _('bookit.settings_value')
            ,dataIndex: 'value'
            ,sortable: false
            ,editor: { xtype: 'textfield', renderer: true }
        }]
    });
    Bookit.grid.settings.superclass.constructor.call(this,config)
};
Ext.extend(Bookit.grid.settings,MODx.grid.Grid, {
	getMenu: function() {
        var m = [{
            text: _('bookit.setting_delete')
            ,handler: this.removeRow
        }];
        this.addContextMenuItem(m);
        return true;
    }
    ,removeRow: function(btn,e) {
        MODx.msg.confirm({ 
            title: _('bookit.setting_delete') 
            ,text: _('bookit.setting_delete_confirm') 
            ,url: this.config.url 
            ,params: { 
                action: 'mgr/bookit/settings/removeRow'
                ,id: this.menu.record.id
            } 
            ,listeners: { 
                'success': {fn:this.refresh,scope:this} 
            } 
        });
    }

});
Ext.reg('bookit-grid-settings',Bookit.grid.settings);

Bookit.window.NewSetting = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('bookit.addNewSetting')
        ,url: Bookit.config.connectorUrl
        ,baseParams: {
            action: 'mgr/bookit/settings/addRow'
            ,openschedule_list: MODx.request.id
        }
        ,fields: [{
            xtype: 'textfield'
            ,fieldLabel: _('bookit.settings_key')
            ,name: 'key'
            ,width: 300
        },{
            xtype: 'textfield'
            ,fieldLabel: _('bookit.settings_value')
            ,name: 'value'
            ,width: 300
        }]
    });
    Bookit.window.NewSetting.superclass.constructor.call(this,config);
};
Ext.extend(Bookit.window.NewSetting,MODx.Window);
Ext.reg('bookit-window-settings-new',Bookit.window.NewSetting);

