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
    	},{
            text: _('bookit.newPermanentPass')
            ,handler: function(btn, e){
                this.newPermanentPass = MODx.load({
                    xtype: 'bookit-window-new-permanent-pass'
                });

                this.newPermanentPass.show(e.target);
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



Bookit.window.NewPermanentPass = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'bookit-window-new-permanent-pass'
        ,title: _('bookit.newPermanentPass')
        ,closeAction: 'close'
        ,width: 500
        ,url: Bookit.config.connectorUrl
        ,baseParams: {
            action: 'mgr/bookit/users/newPermanentPass'
        }
        ,fields: [{
            layout:'column'
            ,border: false
            ,anchor: '100%'
            ,defaults: {
                labelSeparator: ''
                ,labelAlign: 'top'
                ,border: false
                ,layout: 'form'
                ,msgTarget: 'under'
            }
            ,items:[{
                columnWidth: .7
                ,items: [{
                    xtype: 'bookit-extra-userlist-live'
                    ,fieldLabel: _('bookit.fullname')
                    ,name: 'fullname'
                    ,width: 300
                    ,listeners: {
                        'select': {fn:this.findUser,scope:this}
                        ,'change': function(){
                            if(typeof(this.value) == "string"){
                                Ext.getCmp('bookit-window-newbook').setValues({phone: '', email: '', credit: '', warnings: '', debt: ''});
                            }
                        }
                    }
                },{
                    xtype: 'textfield'
                    ,fieldLabel: _('bookit.phone')
                    ,name: 'phone'
                    ,width: 300
                },{
                    xtype: 'textfield'
                    ,fieldLabel: _('email')
                    ,name: 'email'
                    ,width: 300
                },{
                    xtype: 'bookit-extra-combo-items'
                    ,fieldLabel: _('bookit.item')
                    ,name: 'item'
                    ,width: 300
                    ,listeners: {
                        'select': {fn:this.setPermanentPassPrice,scope:this}
                        ,'change': {fn:this.setPermanentPassPrice,scope:this}
                    }
                },{
                    xtype: 'timefield'
                    ,fieldLabel: _('bookit.time')
                    ,format: MODx.config.manager_time_format
                    ,increment: 60
                    ,minValue: '7:00'
                    ,maxValue: '21:00'
                    ,name: 'time'
                    ,width: 300
                    ,listeners: {
                        'select': {fn:this.setPermanentPassPrice,scope:this}
                        ,'change': {fn:this.setPermanentPassPrice,scope:this}
                    }
                },{
                    xtype: 'datefield'
                    ,fieldLabel: _('bookit.date')
                    ,format: MODx.config.manager_date_format
                    ,name: 'date'
                    ,id: 'date'
                    ,startDay: 1
                    ,width: 300
                    ,listeners: {
                        'select': {fn:this.setPermanentPassPrice,scope:this}
                        ,'change': {fn:this.setPermanentPassPrice,scope:this}
                    }
                }]
            },{
                columnWidth: .3
                ,items: [{
                    xtype: 'statictextfield'
                    ,fieldLabel: _('bookit.credit')
                    ,name: 'credit'
                },{
                    xtype: 'statictextfield'
                    ,fieldLabel: _('bookit.warnings')
                    ,name: 'warnings'
                },{
                    xtype: 'statictextfield'
                    ,fieldLabel: _('bookit.debt')
                    ,name: 'debt'
                },{
                    xtype: 'statictextfield'
                    ,fieldLabel: 'Cena permanentky'
                    ,name: 'permanentPassPrice'
                }]
            }]
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
    Bookit.window.NewPermanentPass.superclass.constructor.call(this,config);

    this.on('show', function(){
        var task = new Ext.util.DelayedTask(function(){
            this.fp.getForm().el.dom[1].select();
        }, this);
        task.delay(200);
    });

    this.on('success', function(){Ext.getCmp('bookit-window-new-permanent-pass').close();});

};

Ext.extend(Bookit.window.NewPermanentPass,MODx.Window, {
    findUser: function() {
        var userid = Ext.getCmp('bookit-extra-userlist-live').value
        var newPermanentPass = this;
        MODx.Ajax.request({
            url: Bookit.config.connectorUrl
            ,params: {
                action: 'mgr/bookit/board/getUserDetails'
                ,id: userid
            }
            ,listeners: {
                'success': {fn:function(r) {
                    newPermanentPass.setValues(r.object);
                    if(r.object.warnings > 0){
                        newPermanentPass.fp.getForm().getEl().dom[9].style.setProperty('color', 'red', '');
                    }else{
                        newPermanentPass.fp.getForm().getEl().dom[9].style.removeProperty('color');
                    }

                },scope:this}
            }
        });
    }
    ,setPermanentPassPrice: function() {
        var item = Ext.getCmp('bookit-window-new-permanent-pass').fp.getForm().getFieldValues().items;
        var time = Ext.getCmp('bookit-window-new-permanent-pass').fp.getForm().getFieldValues().time;
        var date = Ext.getCmp('bookit-window-new-permanent-pass').fp.getForm().getFieldValues().date;
        var newPermanentPass = this;
        MODx.Ajax.request({
            url: Bookit.config.connectorUrl
            ,params: {
                action: 'mgr/bookit/users/getPermanentPassPrice'
                ,item: item
                ,time: time
                ,date: date
            }
            ,listeners: {
                'success': {fn:function(r) {
                    newPermanentPass.setValues(r.object);
                },scope:this}
            }
        });
    }

});
Ext.reg('bookit-window-new-permanent-pass',Bookit.window.NewPermanentPass);