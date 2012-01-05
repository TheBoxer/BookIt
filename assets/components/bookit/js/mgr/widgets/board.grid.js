Bookit.grid.Board = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'bookit-grid-board'
        ,url: Bookit.config.connectorUrl
        ,baseParams: { action: 'mgr/bookit/getReservations' }
        ,fields: boarderFields
        ,autosave: true
        ,paging: true
        ,remoteSort: true
        ,enableDragDrop: false
        ,enableColumnMove: false
        ,anchor: '97%'
        ,autoExpandColumn: 'name'
    	,listeners: {
    		'cellcontextmenu': {fn:this.cellContextMenu}
        	,'afterrender': {fn:function(){
        		var mainquoterefresh = { 
				    run: function(){ 
				    	Ext.getCmp('bookit-grid-board').store.load();
				    }, 
				    interval: 600000 //600 second 
				} 
				Ext.TaskMgr.start(mainquoterefresh); 
        	}}
        }
		,tbar:[{
			xtype: 'datefield'
			,id: 'dateFilter'
			,format: 'd.m.Y'
			,emptyText: _('bookit.today')
			,listeners: {
                'select': {fn:this.filterDay,scope:this}
            }
		}]
		,itemOpen: function() {
			location.href = 'index.php?a='+MODx.action['controllers/index']+'&action=openSchedule'+'&id='+this.menu.record.id;
		}
        ,columns: columns
    });
    Bookit.grid.Board.superclass.constructor.call(this,config);
    
	
};
Ext.extend(Bookit.grid.Board,MODx.grid.Grid, {
	filterDay: function(cb,nv,ov) {
        this.getStore().setBaseParam('filterDay',cb.getValue());
        this.getBottomToolbar().changePage(1);
        this.refresh();
    }
	,cancelBook: function(par) {
		var fromWindow = false;
		if(par['id'] == 'X'){
			par['id'] = Ext.getCmp('bookit-window-details').record.id;
			fromWindow = true;
		}
	    MODx.msg.confirm({ 
	        title: _('bookit.cancelBook')
	        ,text: _('bookit.cancelBook_confirm') 
	        ,url: Bookit.config.connectorUrl 
	        ,params: { 
	            action: 'mgr/bookit/board/cancelBook'   
	            ,id: par['id']
	    		,time: par['time']
	    		,date: par['date']
	    		,colName: par['colName']
	        } 
	        ,listeners: { 
	            'success': {fn:function(){
	            	if(fromWindow){
	            		Ext.getCmp('bookit-window-details').close();
	            	}
	            	Ext.getCmp('bookit-grid-board').refresh();
	            },scope:Ext.getCmp('bookit-grid-board')} 
	            
	        } 
	    });
	}
    ,cellContextMenu: function(grid, rowIndex, cellIndex, e) {     		
	    	var row = grid.store.data.items[rowIndex];
			var colName = grid.colModel.config[cellIndex].dataIndex;
			var val = row.data[colName];
			var time = row.data['time'];
			var paid;
			
			if(val.search("\"red\"") == -1){
				paid = true;
			}else{
				paid = false;
			}
			
			val = val.replace('<span class=\"red\">', '');
			val = val.replace('<span class=\"green\">', '');
			val = val.replace('</span>', '');
			
			var currentHour = time.split(":")[0];
			var lastHour = grid.store.data.items[grid.store.data.items.length-1].data["time"].split(":")[0]
			var maxStep = lastHour-currentHour+1;
			
			var iditem = colName.split('-');
			iditem = iditem[1];
	 	 
	    	if(cellIndex > 0){
	    		cellIndex -= 1;
	    		menu = new Ext.menu.Menu();
		    	if(val == ""){
		    		menu.add({
			    			text: _('bookit.newBook')
			    			,handler: function(btn, e){
			    				this.newReseravtionWindow = MODx.load({
		    			            xtype: 'bookit-window-newbook'
		    			            ,record: {item: iditem, time: time}
		    			        });		    		    			    
			    				
			    				this.newReseravtionWindow.fp.getForm().items.items[5].maxValue = maxStep;
			    				this.newReseravtionWindow.fp.getForm().items.items[6].maxValue = maxStep;
			    				this.newReseravtionWindow.show(e.target);
			    			}
			    		});
		    	}else{
		    		if(!paid){
		    			menu.add({
		    				text: _('bookit.pay')
		    			});
		    			menu.add('-');
		    		}
		    		menu.add({
			    			text: _('bookit.viewDetail')
			    			,handler: function(){
			    				MODx.Ajax.request({
			    		            url: Bookit.config.connectorUrl
			    		            ,params: {
			    		                action: 'mgr/bookit/board/getBookDetail'
		    		                	,time: time
			    		                ,colName: colName
			    		                ,val: val
			    		                ,date: Ext.getCmp('dateFilter').value
			    		            }
			    			        ,listeners: {
			    			            'success': {fn:function(r) {		    			        
			    			            	
			    			            	this.detailsWindow = MODx.load({
		    		    			            xtype: 'bookit-window-details'
		    		    			            ,listeners: {
		    		    			                'success': {fn:this.refresh,scope:this}
		    		    			            }
		    		    			        });	
			    			            this.detailsWindow.setValues(r.object);
		    		    			    this.detailsWindow.show(e.target);
		    		    			    if(r.object.credit.split(" ")[0] != 0 && !paid){
		    		    			    	Ext.getCmp('bookit-window-details-credit-pay').show();
		    		    			    }
		    		    			    if(paid){
		    		    			    	Ext.getCmp('bookit-window-details-credit-pay').hide();
		    		    			    	Ext.getCmp('bookit-window-details-pay').hide();
		    		    			    }
			    			            },scope:this}
			    			        }
			    		        });
			    				
			    			}
			    		},'-',{
			    			text: _('bookit.cancelBook')
			    			,handler: this.cancelBook.createDelegate(this, [{time:time, colName:colName, date:Ext.getCmp('dateFilter').value}], false)
			    		});
		    	}
		    	menu.showAt(e.getXY());
		    	
	    	}
    	
    }
    	
    
});
Ext.reg('bookit-grid-board',Bookit.grid.Board);

Bookit.window.Details = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'bookit-window-details'
        ,title: _('bookit.bookDetail')
        ,url: Bookit.config.connectorUrl
        ,closeAction: 'close'
    	,fields:[{
            xtype: 'hidden'
            ,name: 'id'
        },{
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
                columnWidth: .6
                ,items: [{
                    xtype: 'statictextfield'
                	,fieldLabel: _('bookit.fullname')
                    ,name: 'fullname'
                },{
                    xtype: 'statictextfield'
                	,fieldLabel: _('bookit.phone')
                    ,name: 'phone'
                },{
                	xtype: 'statictextfield'
                    ,fieldLabel: _('email')
                    ,name: 'email'
                }]
            },{
                columnWidth: .4
                ,items: [{
                    xtype: 'statictextfield'
                    ,fieldLabel: _('bookit.date')
                    ,name: 'date'
                },{
                    xtype: 'statictextfield'
                    ,fieldLabel: _('bookit.time')
                    ,name: 'time'
                },{
                    xtype: 'statictextfield'
                    ,fieldLabel: _('bookit.item')
                    ,name: 'item'
                }]

            }]
        },{
            html: '<hr />'
        },{
            xtype: 'statictextfield'
            ,fieldLabel: _('bookit.credit')
            ,name: 'credit'
        }]
        ,buttons: [{
            text:  _('bookit.pay')
            ,id: 'bookit-window-details-pay'
            ,scope: this
            ,hidden: false
        },{
            text:  _('bookit.pay_credit')
            ,id: 'bookit-window-details-credit-pay'
            ,scope: this
            ,hidden: true
        },{
            text:  _('bookit.cancelBook')
            ,scope: this
            ,handler: Ext.getCmp('bookit-grid-board').cancelBook.createDelegate(this, [{id:'X'}], false)
        },{
            text: config.cancelBtnText || _('cancel')
            ,scope: this
            ,handler: function() { this.close(); }
        }]
    });
    Bookit.window.Details.superclass.constructor.call(this,config);
};
Ext.extend(Bookit.window.Details,MODx.Window);
Ext.reg('bookit-window-details',Bookit.window.Details);

Bookit.window.NewBook = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'bookit-window-newbook'
        ,title: _('bookit.newBook')
        ,closeAction: 'close'
        ,url: Bookit.config.connectorUrl
        ,baseParams: { 
        	action: 'mgr/bookit/board/saveBook'
        }
        ,fields: [{
            xtype: 'bookit-extra-userlist-live'
            ,fieldLabel: _('bookit.fullname')
            ,name: 'fullname'
            ,width: 300
            ,listeners: {
                'select': {fn:this.findUser,scope:this}
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
        },{
            xtype: 'timefield'
            ,fieldLabel: _('bookit.time')
            ,format: MODx.config.manager_time_format
            ,increment: 60
            ,minValue: '7:00'
            ,maxValue: '21:00'
            ,name: 'time'
            ,width: 300
        },{
            xtype: 'numberfield'
            ,fieldLabel: _('bookit.hourCount')
            ,id: 'count'
            ,name: 'count'
            ,minValue: 1
            ,enableKeyEvents:true
            ,maxValue: 15
            ,width: 300
            ,listeners:{
            	keyup:function(field, e){
                	Ext.getCmp('sliderCount').setValue(parseInt(field.getRawValue()));
                }
            }
        },{
            xtype: 'sliderfield'
            ,name: 'sliderCount'
            ,id: 'sliderCount'
            ,useTips: false
            ,minValue: 1
            ,maxValue: 15
            ,increment: 1
            ,width: 300
            ,scope: this
            
        },{
            xtype: 'hidden'
            ,name: 'date'
            ,id: 'date'
            ,value: Ext.getCmp('dateFilter').value
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
    Bookit.window.NewBook.superclass.constructor.call(this,config);
    Ext.getCmp('sliderCount').slider.on('change', function(slider,newvalue,oldvalue){Ext.getCmp('count').setValue(newvalue);});
	
	this.on('show', function(){
		var task = new Ext.util.DelayedTask(function(){
			this.fp.getForm().el.dom[1].select();
		}, this);
		task.delay(200); 
	});
	
	this.on('success', function(){Ext.getCmp('bookit-window-newbook').close();Ext.getCmp('bookit-grid-board').refresh();});
};

Ext.extend(Bookit.window.NewBook,MODx.Window, {
	findUser: function() {
		var userid = Ext.getCmp('bookit-extra-userlist-live').value
		var newBookWindow = this;
		MODx.Ajax.request({
            url: Bookit.config.connectorUrl
            ,params: {
                action: 'mgr/bookit/board/getUserDetails'
                ,id: userid
            }
	        ,listeners: {
	            'success': {fn:function(r) {		    			        
	            	newBookWindow.setValues(r.object);
	            },scope:this}
	        }
        });
    }
	
});
Ext.reg('bookit-window-newbook',Bookit.window.NewBook);
	
	
