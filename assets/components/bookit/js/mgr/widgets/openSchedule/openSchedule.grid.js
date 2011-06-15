Bookit.grid.OpenSchedule = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'bookit-grid-openschedule'
        ,url: Bookit.config.connectorUrl
        ,baseParams: { action: 'mgr/bookit/openSchedule/getRows'}
        ,fields: ['id', 'name','description']
        ,paging: true
        ,remoteSort: true
        ,enableDragDrop: false
        ,anchor: '97%'
        ,autoExpandColumn: 'name'
        ,save_action: 'mgr/bookit/openSchedule/updateFromGrid'
        ,autosave: true
        ,tbar:[{
           text: _('bookit.addOpenschedule')
           ,handler: { xtype: 'bookit-window-openschedule-new', blankValues: true }
        }]
        ,getMenu: function() {
            var m = [{
            	text: _('bookit.openschedule_settings')
            	,handler: this.openScheduleSettings
            },'-',{
            	text: _('bookit.pricing')
            	,handler: this.pricing
            },'-',{
                text: _('bookit.openschedule_delete')
                ,handler: this.removeOpenSchedule
            }];
            this.addContextMenuItem(m);
            return true;
        }
        ,removeOpenSchedule: function(btn,e) {
            MODx.msg.confirm({ 
                title: _('bookit.openschedule_delete') 
                ,text: _('bookit.openschedule_delete_confirm') 
                ,url: this.config.url 
                ,params: { 
                    action: 'mgr/bookit/openSchedule/removeRow'
                    ,id: this.menu.record.id
                } 
                ,listeners: { 
                    'success': {fn:this.refresh,scope:this} 
                } 
            });
        }
        ,openScheduleSettings: function() {
        	location.href = 'index.php?a='+MODx.action['controllers/index']+'&action=openScheduleItems'+'&id='+this.menu.record.id;
        }
        ,pricing: function() {
        	location.href = 'index.php?a='+MODx.action['controllers/index']+'&action=pricing'+'&id='+this.menu.record.id;
        }
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
    Bookit.grid.OpenSchedule.superclass.constructor.call(this,config)
};
Ext.extend(Bookit.grid.OpenSchedule,MODx.grid.Grid);
Ext.reg('bookit-grid-openschedule',Bookit.grid.OpenSchedule);

Bookit.window.NewOpenSchedule = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('bookit.addOpenschedule')
        ,url: Bookit.config.connectorUrl
        ,baseParams: {
            action: 'mgr/bookit/openSchedule/addOpenSchedule'
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
    Bookit.window.NewOpenSchedule.superclass.constructor.call(this,config);
};
Ext.extend(Bookit.window.NewOpenSchedule,MODx.Window);
Ext.reg('bookit-window-openschedule-new',Bookit.window.NewOpenSchedule);
