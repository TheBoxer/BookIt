Bookit.grid.Items = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'bookit-grid-items'
        ,url: Bookit.config.connectorUrl
        ,baseParams: { action: 'mgr/bookit/items/getItems' }
        ,fields: ['id','name', 'active', 'openschedule', 'pricing', 'pricing_label', 'openschedule_label']
        ,save_action: 'mgr/bookit/items/updateFromGrid'
        ,autosave: true
        ,paging: true
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
				text: _('bookit.set_openschedule')
				,handler: this.setSchedule
			},{
				text: _('bookit.set_pricing')
				,handler: this.setPricing
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
            ,editor: { xtype: 'textfield' }
            ,sortable: false
        },{
        	header: _('bookit.openschedule')
        	,dataIndex: 'openschedule_label'    	
        },{
        	header: _('bookit.item_pricing')
        	,dataIndex: 'pricing_label'
        },{
        	header: _('bookit.item_active')
        	,dataIndex: 'active'
        	,editor: { xtype: 'modx-combo-boolean', renderer: true}
        }]
    });
    Bookit.grid.Items.superclass.constructor.call(this,config)
};
Ext.extend(Bookit.grid.Items,MODx.grid.Grid, {
	setSchedule: function(btn,e) {
	    if (!this.setScheduleWindow) {
	        this.setScheduleWindow = MODx.load({
	            xtype: 'bookit-window-setopenschedule'
	            ,record: this.menu.record
	            ,listeners: {
	                'success': {fn:this.refresh,scope:this}
	            }
	        });
	    } else {
	        this.setScheduleWindow.setValues(this.menu.record);
	    }
	    this.setScheduleWindow.show(e.target);
	}
	,setPricing: function(btn,e) {
        this.setPricingWindow = MODx.load({
            xtype: 'bookit-window-setpricing'
            ,record: this.menu.record
            ,listeners: {
                'success': {fn:this.refresh,scope:this}
            }
        });
        
	    this.setPricingWindow.show(e.target);
	}

});
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

Bookit.window.SetOpenschedule = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('bookit.set_openschedule')
        ,url: Bookit.config.connectorUrl
        ,baseParams: {
            action: 'mgr/bookit/items/setOpenSchedule'
        }
        ,fields: [{
            xtype: 'hidden'
            ,name: 'id'
        },{
            xtype: 'bookit-extra-combo-openschedule'
            ,fieldLabel: _('bookit.openschedule')
            ,name: 'openschedule'
            ,width: 300
        }]
    });
    Bookit.window.SetOpenschedule.superclass.constructor.call(this,config);
};
Ext.extend(Bookit.window.SetOpenschedule,MODx.Window);
Ext.reg('bookit-window-setopenschedule',Bookit.window.SetOpenschedule);

Bookit.window.SetPricing = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('bookit.set_pricing')
        ,url: Bookit.config.connectorUrl
        ,closeAction: 'close'
        ,baseParams: {
            action: 'mgr/bookit/items/setPricing'
        }
        ,fields: [{
            xtype: 'hidden'
            ,name: 'id'
        },{
            xtype: 'bookit-extra-combo-pricing'
            ,baseParams: { action: 'mgr/bookit/extra/getPricing', itemid: config.record.id }
            ,fieldLabel: _('bookit.item_pricing')
            ,name: 'pricing'
            ,width: 300
        }]
        ,buttons: [{
            text: config.cancelBtnText || _('cancel')
            ,scope: this
            ,handler: function() { this.close(); }
        },{
            text: config.saveBtnText || _('save')
            ,scope: this
            ,handler: this.submit
        }]
    });
    Bookit.window.SetPricing.superclass.constructor.call(this,config);
};
Ext.extend(Bookit.window.SetPricing,MODx.Window);
Ext.reg('bookit-window-setpricing',Bookit.window.SetPricing);

