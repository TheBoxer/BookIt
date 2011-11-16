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
    	var callback = function(par){
    		var grid = par['grid']
    		var rowIndex = par['rowIndex']
    		var cellIndex = par['cellIndex']
    		var e = par['e']
    		
	    	var row = grid.store.data.items[rowIndex];
			var colName = grid.colModel.config[cellIndex].dataIndex;
			var val = row.data[colName];
			var time = row.data['time'];
	 	 
	    	if(cellIndex > 0){
	    		cellIndex -= 1;
		    	if(val == ""){
		    		menu = new Ext.menu.Menu({
			    		items:[{
			    			text: 'New reservation'
			    			,handler: function(){
			    				alert(cellIndex);
			    			}
			    		}]
			    	});
		    	}else{
		    		menu = new Ext.menu.Menu({
			    		items:[{
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
			    		    			            ,record: r.object
			    		    			            ,listeners: {
			    		    			                'success': {fn:this.refresh,scope:this}
			    		    			            }
			    		    			        });		    		    			    
			    		    			    this.detailsWindow.show(e.target);
			    			            },scope:this}
			    			        }
			    		        });
			    				
			    			}
			    		},'-',{
			    			text: _('bookit.cancelBook')
			    			,handler: this.cancelBook.createDelegate(this, [{time:time, colName:colName, date:Ext.getCmp('dateFilter').value}], false)
			    		}]
			    	});
		    	}
		    	menu.showAt(e.getXY());
	    	}
    	}
    	
    	var store = Ext.getCmp('bookit-grid-board').store;
    	store.on('load', callback.createDelegate(this, [{rowIndex:rowIndex, grid:grid, cellIndex:cellIndex, e:e}], false));
    	store.reload();
    }
    	
    
});
Ext.reg('bookit-grid-board',Bookit.grid.Board);

Bookit.window.Details = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'bookit-window-details'
        ,title: _('bookit.bookDetail')
        ,url: Bookit.config.connectorUrl
        ,fields: [{
            xtype: 'hidden'
            ,name: 'id'
        },{
            focus: true
            ,xtype: 'statictextfield'
            ,fieldLabel: _('bookit.fullname')
            ,name: 'fullname'
            ,width: 300
        },{
            focus: true
            ,xtype: 'statictextfield'
            ,fieldLabel: _('bookit.phone')
            ,name: 'phone'
            ,width: 300
        },{
            focus: true
            ,xtype: 'statictextfield'
            ,fieldLabel: _('bookit.date')
            ,name: 'date'
            ,width: 300
        },{
            focus: true
            ,xtype: 'statictextfield'
            ,fieldLabel: _('bookit.time')
            ,name: 'time'
            ,width: 300
        },{
            focus: true
            ,xtype: 'statictextfield'
            ,fieldLabel: _('bookit.item')
            ,name: 'item'
            ,width: 300
        }]
        ,buttons: [{
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


