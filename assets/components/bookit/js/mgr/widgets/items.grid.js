Bookit.grid.Items = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'bookit-grid-items'
        ,url: Bookit.config.connectorUrl
        ,baseParams: { action: 'mgr/bookit/items/getItems' }
        ,fields: ['id','name', 'active']
        ,paging: false
        ,remoteSort: true
        ,enableDragDrop: false
        ,anchor: '97%'
        ,autoExpandColumn: 'name'
		,tbar:[{
		   text: _('bookit.add_item')
		   ,handler: { xtype: 'bookit-window-item-add', blankValues: true }
		}]
		,getMenu: function() {
			var m = [{
				text: _('bookit.openschedule')
				,handler: this.itemOpen
			}];
			this.addContextMenuItem(m);
			return true;
		}
		,itemOpen: function() {
			location.href = 'index.php?a='+MODx.action['controllers/index']+'&action=openSchedule'+'&id='+this.menu.record.id;
		}
        ,columns: [{
            header: _('bookit.item_name')
            ,dataIndex: 'name'
            ,sortable: false
        }]
    });
    Bookit.grid.Items.superclass.constructor.call(this,config)
};
Ext.extend(Bookit.grid.Items,MODx.grid.Grid);
Ext.reg('bookit-grid-items',Bookit.grid.Items);

Bookit.window.AddItem = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('bookit.add_item')
        ,url: Bookit.config.connectorUrl
        ,baseParams: {
            action: 'mgr/bookit/items/add'
        }
        ,fields: [{
            xtype: 'textfield'
            ,fieldLabel: _('bookit.item_name')
            ,name: 'name'
            ,width: 300
        },{
            xtype: 'xcheckbox'
            ,fieldLabel: _('bookit.item_active')
            ,name: 'active'
            ,width: 300
        }]
    });
    Bookit.window.AddItem.superclass.constructor.call(this,config);
};
Ext.extend(Bookit.window.AddItem,MODx.Window);
Ext.reg('bookit-window-item-add',Bookit.window.AddItem);