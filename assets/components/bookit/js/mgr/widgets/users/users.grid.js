Bookit.grid.Users = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'bookit-grid-users'
        ,url: Bookit.config.connectorUrl
        ,baseParams: { action: 'mgr/bookit/users/getRows' }
        ,fields: ['id','fullname', 'credit', 'warnings', 'debt']
        ,autosave: true
        ,paging: true
        ,remoteSort: false
        ,enableDragDrop: false
        ,anchor: '97%'
        ,autoExpandColumn: 'fullname'
    	,tbar:[{
    	    xtype: 'textfield'
    	    ,id: 'bookit-gird-users-search'
    	    ,emptyText: _('bookit.search')
    	    ,listeners: {
    	        'change': {fn:this.search,scope:this}
    	        ,'render': {fn: function(cmp) {
    	            new Ext.KeyMap(cmp.getEl(), {
    	                key: Ext.EventObject.ENTER
    	                ,fn: function() {
    	                    this.fireEvent('change',this);
    	                    this.blur();
    	                    return true;
    	                }
    	                ,scope: cmp
    	            });
    	        },scope:this}
    	    }
    	}]
        ,getMenu: function() {
			var m = [{
				text: _('bookit.add_credit')
				,handler: this.addCredit
			}];
			
			if(this.menu.record.debt != 0){
				m.push({
					text: _('bookit.pay_debt')
					,handler: this.payDebt
				});
			}
			
			
			this.addContextMenuItem(m);
			return true;
		}
        ,columns: [{
        	header: _('id')
        	,dataIndex: 'id'
        	,sortable: true
        },{
        	header: _('bookit.fullname')
            ,dataIndex: 'fullname'
            ,sortable: true
        },{
        	header: _('bookit.credit')
            ,dataIndex: 'credit'
            ,sortable: true
        },{
        	header: _('bookit.warnings')
            ,dataIndex: 'warnings'
            ,sortable: true
        },{
        	header: _('bookit.debt')
            ,dataIndex: 'debt'
            ,sortable: true
        }]
    });
    Bookit.grid.Users.superclass.constructor.call(this,config)
};
Ext.extend(Bookit.grid.Users,MODx.grid.Grid, {
    search: function(tf,nv,ov) {
        var s = this.getStore();
        s.baseParams.query = tf.getValue();
        this.getBottomToolbar().changePage(1);
        this.refresh();
    }
	,payDebt: function(btn,e) {
		console.log(this.menu.record);
		debt = this.menu.record.debt;
		debt = debt.replace('<span class=\"red\">', '');
		debt = debt.replace('<span class=\"green\">', '');
		debt = debt.replace('</span>', '');

		MODx.Ajax.request({
            url: Bookit.config.connectorUrl
            ,params: {
                action: 'mgr/bookit/users/payDebt'
            	,id: this.menu.record.id
            }
			,listeners: {
	            'success': {fn:function(r) {		    			                  	
	            	MODx.msg.alert(_('bookit.paid'),_('bookit.paid_debt_desc'),null,MODx);
	            	Ext.getCmp('bookit-grid-users').refresh();
	            }}
			}
        });
		
	}
	,addCredit: function(btn,e) {
		if (!this.addCreditWindow) {
	        this.addCreditWindow = MODx.load({
	            xtype: 'bookit-users-addcredit'
	            ,record: this.menu.record
	            ,listeners: {
	                'success': {fn:this.refresh,scope:this}
	            }
	        });
	    } else {
	        this.addCreditWindow.setValues({id: this.menu.record.id});
	    }
	    this.addCreditWindow.show(e.target);

		
	}
});
Ext.reg('bookit-grid-users',Bookit.grid.Users);

Bookit.window.AddCredit = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('bookit.add_credit')
        ,url: Bookit.config.connectorUrl
        ,baseParams: {
            action: 'mgr/bookit/users/addCredit'
        }
        ,fields: [{
            xtype: 'hidden'
            ,name: 'id'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('bookit.credit_count')
            ,name: 'value'
            ,width: 300
        }]
    });
    Bookit.window.AddCredit.superclass.constructor.call(this,config);
};
Ext.extend(Bookit.window.AddCredit,MODx.Window);
Ext.reg('bookit-users-addcredit',Bookit.window.AddCredit);
