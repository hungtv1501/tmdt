VatGiaChatCreateCookie("chat_guest_id",1283612941,200);
console.log('file:', '../static_file/socket.io.1.0.js');!function(t){"object"==typeof exports?module.exports=t():"undefined"!=typeof window?window.io=t():"undefined"!=typeof global?global.io=t():"undefined"!=typeof self&&(self.io=t())}(function(){var t;return function e(t,n,r){function o(s,a){if(!n[s]){if(!t[s]){var c="function"==typeof require&&require;if(!a&&c)return c(s,!0);if(i)return i(s,!0);throw new Error("Cannot find module '"+s+"'")}var p=n[s]={exports:{}};t[s][0].call(p.exports,function(e){var n=t[s][1][e];return o(n?n:e)},p,p.exports,e,t,n,r)}return n[s].exports}for(var i="function"==typeof require&&require,s=0;s<r.length;s++)o(r[s]);return o}({1:[function(t,e){e.exports=t("./lib/")},{"./lib/":2}],2:[function(t,e,n){function r(t,e){"object"==typeof t&&(e=t,t=void 0),e=e||{};var n,r=o(t),i=r.source,p=r.id;return e.forceNew||e["force new connection"]||!1===e.multiplex?(a("ignoring socket cache for %s",i),n=s(i,e)):(c[p]||(a("new io instance for %s",i),c[p]=s(i,e)),n=c[p]),n.socket(r.path)}var o=t("./url"),i=t("socket.io-parser"),s=t("./manager"),a=t("debug")("socket.io-client");e.exports=n=r;var c=n.managers={};n.protocol=i.protocol,n.connect=r,n.Manager=t("./manager"),n.Socket=t("./socket")},{"./manager":3,"./socket":5,"./url":6,debug:9,"socket.io-parser":40}],3:[function(t,e){function n(t,e){return this instanceof n?(t&&"object"==typeof t&&(e=t,t=void 0),e=e||{},e.path=e.path||"/socket.io",this.nsps={},this.subs=[],this.opts=e,this.reconnection(e.reconnection!==!1),this.reconnectionAttempts(e.reconnectionAttempts||1/0),this.reconnectionDelay(e.reconnectionDelay||1e3),this.reconnectionDelayMax(e.reconnectionDelayMax||5e3),this.timeout(null==e.timeout?2e4:e.timeout),this.readyState="closed",this.uri=t,this.connected=0,this.attempts=0,this.encoding=!1,this.packetBuffer=[],this.encoder=new s.Encoder,this.decoder=new s.Decoder,void this.open()):new n(t,e)}var r=(t("./url"),t("engine.io-client")),o=t("./socket"),i=t("component-emitter"),s=t("socket.io-parser"),a=t("./on"),c=t("component-bind"),p=(t("object-component"),t("debug")("socket.io-client:manager"));e.exports=n,n.prototype.emitAll=function(){this.emit.apply(this,arguments);for(var t in this.nsps)this.nsps[t].emit.apply(this.nsps[t],arguments)},i(n.prototype),n.prototype.reconnection=function(t){return arguments.length?(this._reconnection=!!t,this):this._reconnection},n.prototype.reconnectionAttempts=function(t){return arguments.length?(this._reconnectionAttempts=t,this):this._reconnectionAttempts},n.prototype.reconnectionDelay=function(t){return arguments.length?(this._reconnectionDelay=t,this):this._reconnectionDelay},n.prototype.reconnectionDelayMax=function(t){return arguments.length?(this._reconnectionDelayMax=t,this):this._reconnectionDelayMax},n.prototype.timeout=function(t){return arguments.length?(this._timeout=t,this):this._timeout},n.prototype.maybeReconnectOnOpen=function(){this.openReconnect||this.reconnecting||!this._reconnection||(this.openReconnect=!0,this.reconnect())},n.prototype.open=n.prototype.connect=function(t){if(p("readyState %s",this.readyState),~this.readyState.indexOf("open"))return this;p("opening %s",this.uri),this.engine=r(this.uri,this.opts);var e=this.engine,n=this;this.readyState="opening";var o=a(e,"open",function(){n.onopen(),t&&t()}),i=a(e,"error",function(e){if(p("connect_error"),n.cleanup(),n.readyState="closed",n.emitAll("connect_error",e),t){var r=new Error("Connection error");r.data=e,t(r)}n.maybeReconnectOnOpen()});if(!1!==this._timeout){var s=this._timeout;p("connect attempt will timeout after %d",s);var c=setTimeout(function(){p("connect attempt timed out after %d",s),o.destroy(),e.close(),e.emit("error","timeout"),n.emitAll("connect_timeout",s)},s);this.subs.push({destroy:function(){clearTimeout(c)}})}return this.subs.push(o),this.subs.push(i),this},n.prototype.onopen=function(){p("open"),this.cleanup(),this.readyState="open",this.emit("open");var t=this.engine;this.subs.push(a(t,"data",c(this,"ondata"))),this.subs.push(a(this.decoder,"decoded",c(this,"ondecoded"))),this.subs.push(a(t,"error",c(this,"onerror"))),this.subs.push(a(t,"close",c(this,"onclose")))},n.prototype.ondata=function(t){this.decoder.add(t)},n.prototype.ondecoded=function(t){this.emit("packet",t)},n.prototype.onerror=function(t){p("error",t),this.emitAll("error",t)},n.prototype.socket=function(t){var e=this.nsps[t];if(!e){e=new o(this,t),this.nsps[t]=e;var n=this;e.on("connect",function(){n.connected++})}return e},n.prototype.destroy=function(){--this.connected||this.close()},n.prototype.packet=function(t){p("writing packet %j",t);var e=this;e.encoding?e.packetBuffer.push(t):(e.encoding=!0,this.encoder.encode(t,function(t){for(var n=0;n<t.length;n++)e.engine.write(t[n]);e.encoding=!1,e.processPacketQueue()}))},n.prototype.processPacketQueue=function(){if(this.packetBuffer.length>0&&!this.encoding){var t=this.packetBuffer.shift();this.packet(t)}},n.prototype.cleanup=function(){for(var t;t=this.subs.shift();)t.destroy();this.packetBuffer=[],this.encoding=!1,this.decoder.destroy()},n.prototype.close=n.prototype.disconnect=function(){this.skipReconnect=!0,this.engine.close()},n.prototype.onclose=function(t){p("close"),this.cleanup(),this.readyState="closed",this.emit("close",t),this._reconnection&&!this.skipReconnect&&this.reconnect()},n.prototype.reconnect=function(){if(this.reconnecting)return this;var t=this;if(this.attempts++,this.attempts>this._reconnectionAttempts)p("reconnect failed"),this.emitAll("reconnect_failed"),this.reconnecting=!1;else{var e=this.attempts*this.reconnectionDelay();e=Math.min(e,this.reconnectionDelayMax()),p("will wait %dms before reconnect attempt",e),this.reconnecting=!0;var n=setTimeout(function(){p("attempting reconnect"),t.emitAll("reconnect_attempt",t.attempts),t.emitAll("reconnecting",t.attempts),t.open(function(e){e?(p("reconnect attempt error"),t.reconnecting=!1,t.reconnect(),t.emitAll("reconnect_error",e.data)):(p("reconnect success"),t.onreconnect())})},e);this.subs.push({destroy:function(){clearTimeout(n)}})}},n.prototype.onreconnect=function(){var t=this.attempts;this.attempts=0,this.reconnecting=!1,this.emitAll("reconnect",t)}},{"./on":4,"./socket":5,"./url":6,"component-bind":7,"component-emitter":8,debug:9,"engine.io-client":11,"object-component":37,"socket.io-parser":40}],4:[function(t,e){function n(t,e,n){return t.on(e,n),{destroy:function(){t.removeListener(e,n)}}}e.exports=n},{}],5:[function(t,e,n){function r(t,e){this.io=t,this.nsp=e,this.json=this,this.ids=0,this.acks={},this.open(),this.receiveBuffer=[],this.sendBuffer=[],this.connected=!1,this.disconnected=!0,this.subEvents()}{var o=t("socket.io-parser"),i=t("component-emitter"),s=t("to-array"),a=t("./on"),c=t("component-bind"),p=t("debug")("socket.io-client:socket"),u=t("has-binary-data");t("indexof")}e.exports=n=r;var f={connect:1,connect_error:1,connect_timeout:1,disconnect:1,error:1,reconnect:1,reconnect_attempt:1,reconnect_failed:1,reconnect_error:1,reconnecting:1},h=i.prototype.emit;i(r.prototype),r.prototype.subEvents=function(){var t=this.io;this.subs=[a(t,"open",c(this,"onopen")),a(t,"packet",c(this,"onpacket")),a(t,"close",c(this,"onclose"))]},r.prototype.open=r.prototype.connect=function(){return this.connected?this:(this.io.open(),"open"==this.io.readyState&&this.onopen(),this)},r.prototype.send=function(){var t=s(arguments);return t.unshift("message"),this.emit.apply(this,t),this},r.prototype.emit=function(t){if(f.hasOwnProperty(t))return h.apply(this,arguments),this;var e=s(arguments),n=o.EVENT;u(e)&&(n=o.BINARY_EVENT);var r={type:n,data:e};return"function"==typeof e[e.length-1]&&(p("emitting packet with ack id %d",this.ids),this.acks[this.ids]=e.pop(),r.id=this.ids++),this.connected?this.packet(r):this.sendBuffer.push(r),this},r.prototype.packet=function(t){t.nsp=this.nsp,this.io.packet(t)},r.prototype.onopen=function(){p("transport is open - connecting"),"/"!=this.nsp&&this.packet({type:o.CONNECT})},r.prototype.onclose=function(t){p("close (%s)",t),this.connected=!1,this.disconnected=!0,this.emit("disconnect",t)},r.prototype.onpacket=function(t){if(t.nsp==this.nsp)switch(t.type){case o.CONNECT:this.onconnect();break;case o.EVENT:this.onevent(t);break;case o.BINARY_EVENT:this.onevent(t);break;case o.ACK:this.onack(t);break;case o.BINARY_ACK:this.onack(t);break;case o.DISCONNECT:this.ondisconnect();break;case o.ERROR:this.emit("error",t.data)}},r.prototype.onevent=function(t){var e=t.data||[];p("emitting event %j",e),null!=t.id&&(p("attaching ack callback to event"),e.push(this.ack(t.id))),this.connected?h.apply(this,e):this.receiveBuffer.push(e)},r.prototype.ack=function(t){var e=this,n=!1;return function(){if(!n){n=!0;var r=s(arguments);p("sending ack %j",r);var i=u(r)?o.BINARY_ACK:o.ACK;e.packet({type:i,id:t,data:r})}}},r.prototype.onack=function(t){p("calling ack %s with %j",t.id,t.data);var e=this.acks[t.id];e.apply(this,t.data),delete this.acks[t.id]},r.prototype.onconnect=function(){this.connected=!0,this.disconnected=!1,this.emit("connect"),this.emitBuffered()},r.prototype.emitBuffered=function(){var t;for(t=0;t<this.receiveBuffer.length;t++)h.apply(this,this.receiveBuffer[t]);for(this.receiveBuffer=[],t=0;t<this.sendBuffer.length;t++)this.packet(this.sendBuffer[t]);this.sendBuffer=[]},r.prototype.ondisconnect=function(){p("server disconnect (%s)",this.nsp),this.destroy(),this.onclose("io server disconnect")},r.prototype.destroy=function(){for(var t=0;t<this.subs.length;t++)this.subs[t].destroy();this.io.destroy(this)},r.prototype.close=r.prototype.disconnect=function(){return this.connected?(p("performing disconnect (%s)",this.nsp),this.packet({type:o.DISCONNECT}),this.destroy(),this.onclose("io client disconnect"),this):this}},{"./on":4,"component-bind":7,"component-emitter":8,debug:9,"has-binary-data":32,indexof:36,"socket.io-parser":40,"to-array":43}],6:[function(t,e){function n(t,e){var n=t,e=e||r.location;return null==t&&(t=e.protocol+"//"+e.hostname),"string"==typeof t&&("/"==t.charAt(0)&&"undefined"!=typeof e&&(t=e.hostname+t),/^(https?|wss?):\/\//.test(t)||(i("protocol-less url %s",t),t="undefined"!=typeof e?e.protocol+"//"+t:"https://"+t),i("parse %s",t),n=o(t)),n.port||(/^(http|ws)$/.test(n.protocol)?n.port="80":/^(http|ws)s$/.test(n.protocol)&&(n.port="443")),n.path=n.path||"/",n.id=n.protocol+"://"+n.host+":"+n.port,n.href=n.protocol+"://"+n.host+(e&&e.port==n.port?"":":"+n.port),n}var r="undefined"!=typeof self?self:"undefined"!=typeof window?window:{},o=t("parseuri"),i=t("debug")("socket.io-client:url");e.exports=n},{debug:9,parseuri:38}],7:[function(t,e){var n=[].slice;e.exports=function(t,e){if("string"==typeof e&&(e=t[e]),"function"!=typeof e)throw new Error("bind() requires a function");var r=n.call(arguments,2);return function(){return e.apply(t,r.concat(n.call(arguments)))}}},{}],8:[function(t,e){function n(t){return t?r(t):void 0}function r(t){for(var e in n.prototype)t[e]=n.prototype[e];return t}e.exports=n,n.prototype.on=n.prototype.addEventListener=function(t,e){return this._callbacks=this._callbacks||{},(this._callbacks[t]=this._callbacks[t]||[]).push(e),this},n.prototype.once=function(t,e){function n(){r.off(t,n),e.apply(this,arguments)}var r=this;return this._callbacks=this._callbacks||{},n.fn=e,this.on(t,n),this},n.prototype.off=n.prototype.removeListener=n.prototype.removeAllListeners=n.prototype.removeEventListener=function(t,e){if(this._callbacks=this._callbacks||{},0==arguments.length)return this._callbacks={},this;var n=this._callbacks[t];if(!n)return this;if(1==arguments.length)return delete this._callbacks[t],this;for(var r,o=0;o<n.length;o++)if(r=n[o],r===e||r.fn===e){n.splice(o,1);break}return this},n.prototype.emit=function(t){this._callbacks=this._callbacks||{};var e=[].slice.call(arguments,1),n=this._callbacks[t];if(n){n=n.slice(0);for(var r=0,o=n.length;o>r;++r)n[r].apply(this,e)}return this},n.prototype.listeners=function(t){return this._callbacks=this._callbacks||{},this._callbacks[t]||[]},n.prototype.hasListeners=function(t){return!!this.listeners(t).length}},{}],9:[function(t,e){function n(t){return n.enabled(t)?function(e){e=r(e);var o=new Date,i=o-(n[t]||o);n[t]=o,e=t+" "+e+" +"+n.humanize(i),window.console&&console.log&&Function.prototype.apply.call(console.log,console,arguments)}:function(){}}function r(t){return t instanceof Error?t.stack||t.message:t}e.exports=n,n.names=[],n.skips=[],n.enable=function(t){try{localStorage.debug=t}catch(e){}for(var r=(t||"").split(/[\s,]+/),o=r.length,i=0;o>i;i++)t=r[i].replace("*",".*?"),"-"===t[0]?n.skips.push(new RegExp("^"+t.substr(1)+"$")):n.names.push(new RegExp("^"+t+"$"))},n.disable=function(){n.enable("")},n.humanize=function(t){var e=1e3,n=6e4,r=60*n;return t>=r?(t/r).toFixed(1)+"h":t>=n?(t/n).toFixed(1)+"m":t>=e?(t/e|0)+"s":t+"ms"},n.enabled=function(t){for(var e=0,r=n.skips.length;r>e;e++)if(n.skips[e].test(t))return!1;for(var e=0,r=n.names.length;r>e;e++)if(n.names[e].test(t))return!0;return!1};try{window.localStorage&&n.enable(localStorage.debug)}catch(o){}},{}],10:[function(t,e){function n(t){return t?r(t):void 0}function r(t){for(var e in n.prototype)t[e]=n.prototype[e];return t}var o=t("indexof");e.exports=n,n.prototype.on=function(t,e){return this._callbacks=this._callbacks||{},(this._callbacks[t]=this._callbacks[t]||[]).push(e),this},n.prototype.once=function(t,e){function n(){r.off(t,n),e.apply(this,arguments)}var r=this;return this._callbacks=this._callbacks||{},e._off=n,this.on(t,n),this},n.prototype.off=n.prototype.removeListener=n.prototype.removeAllListeners=function(t,e){if(this._callbacks=this._callbacks||{},0==arguments.length)return this._callbacks={},this;var n=this._callbacks[t];if(!n)return this;if(1==arguments.length)return delete this._callbacks[t],this;var r=o(n,e._off||e);return~r&&n.splice(r,1),this},n.prototype.emit=function(t){this._callbacks=this._callbacks||{};var e=[].slice.call(arguments,1),n=this._callbacks[t];if(n){n=n.slice(0);for(var r=0,o=n.length;o>r;++r)n[r].apply(this,e)}return this},n.prototype.listeners=function(t){return this._callbacks=this._callbacks||{},this._callbacks[t]||[]},n.prototype.hasListeners=function(t){return!!this.listeners(t).length}},{indexof:36}],11:[function(t,e){e.exports=t("./lib/")},{"./lib/":12}],12:[function(t,e){e.exports=t("./socket"),e.exports.parser=t("engine.io-parser")},{"./socket":13,"engine.io-parser":22}],13:[function(t,e){function n(t,e){if(!(this instanceof n))return new n(t,e);if(e=e||{},t&&"object"==typeof t&&(e=t,t=null),t&&(t=u(t),e.host=t.host,e.secure="https"==t.protocol||"wss"==t.protocol,e.port=t.port,t.query&&(e.query=t.query)),this.secure=null!=e.secure?e.secure:o.location&&"https:"==location.protocol,e.host){var r=e.host.split(":");e.hostname=r.shift(),r.length&&(e.port=r.pop())}this.agent=e.agent||!1,this.hostname=e.hostname||(o.location?location.hostname:"localhost"),this.port=e.port||(o.location&&location.port?location.port:this.secure?443:80),this.query=e.query||{},"string"==typeof this.query&&(this.query=h.decode(this.query)),this.upgrade=!1!==e.upgrade,this.path=(e.path||"/engine.io").replace(/\/$/,"")+"/",this.forceJSONP=!!e.forceJSONP,this.forceBase64=!!e.forceBase64,this.timestampParam=e.timestampParam||"t",this.timestampRequests=e.timestampRequests,this.transports=e.transports||["polling","websocket"],this.readyState="",this.writeBuffer=[],this.callbackBuffer=[],this.policyPort=e.policyPort||843,this.rememberUpgrade=e.rememberUpgrade||!1,this.open(),this.binaryType=null,this.onlyBinaryUpgrades=e.onlyBinaryUpgrades}function r(t){var e={};for(var n in t)t.hasOwnProperty(n)&&(e[n]=t[n]);return e}var o="undefined"!=typeof self?self:"undefined"!=typeof window?window:{},i=t("./transports"),s=t("component-emitter"),a=t("debug")("engine.io-client:socket"),c=t("indexof"),p=t("engine.io-parser"),u=t("parseuri"),f=t("parsejson"),h=t("parseqs");e.exports=n,n.priorWebsocketSuccess=!1,s(n.prototype),n.protocol=p.protocol,n.Socket=n,n.Transport=t("./transport"),n.transports=t("./transports"),n.parser=t("engine.io-parser"),n.prototype.createTransport=function(t){a('creating transport "%s"',t);var e=r(this.query);e.EIO=p.protocol,e.transport=t,this.id&&(e.sid=this.id);var n=new i[t]({agent:this.agent,hostname:this.hostname,port:this.port,secure:this.secure,path:this.path,query:e,forceJSONP:this.forceJSONP,forceBase64:this.forceBase64,timestampRequests:this.timestampRequests,timestampParam:this.timestampParam,policyPort:this.policyPort,socket:this});return n},n.prototype.open=function(){var t;t=this.rememberUpgrade&&n.priorWebsocketSuccess&&-1!=this.transports.indexOf("websocket")?"websocket":this.transports[0],this.readyState="opening";var t=this.createTransport(t);t.open(),this.setTransport(t)},n.prototype.setTransport=function(t){a("setting transport %s",t.name);var e=this;this.transport&&(a("clearing existing transport %s",this.transport.name),this.transport.removeAllListeners()),this.transport=t,t.on("drain",function(){e.onDrain()}).on("packet",function(t){e.onPacket(t)}).on("error",function(t){e.onError(t)}).on("close",function(){e.onClose("transport close")})},n.prototype.probe=function(t){function e(){if(h.onlyBinaryUpgrades){var e=!this.supportsBinary&&h.transport.supportsBinary;f=f||e}f||(a('probe transport "%s" opened',t),u.send([{type:"ping",data:"probe"}]),u.once("packet",function(e){if(!f)if("pong"==e.type&&"probe"==e.data)a('probe transport "%s" pong',t),h.upgrading=!0,h.emit("upgrading",u),n.priorWebsocketSuccess="websocket"==u.name,a('pausing current transport "%s"',h.transport.name),h.transport.pause(function(){f||"closed"!=h.readyState&&"closing"!=h.readyState&&(a("changing transport and sending upgrade packet"),p(),h.setTransport(u),u.send([{type:"upgrade"}]),h.emit("upgrade",u),u=null,h.upgrading=!1,h.flush())});else{a('probe transport "%s" failed',t);var r=new Error("probe error");r.transport=u.name,h.emit("upgradeError",r)}}))}function r(){f||(f=!0,p(),u.close(),u=null)}function o(e){var n=new Error("probe error: "+e);n.transport=u.name,r(),a('probe transport "%s" failed because of error: %s',t,e),h.emit("upgradeError",n)}function i(){o("transport closed")}function s(){o("socket closed")}function c(t){u&&t.name!=u.name&&(a('"%s" works - aborting "%s"',t.name,u.name),r())}function p(){u.removeListener("open",e),u.removeListener("error",o),u.removeListener("close",i),h.removeListener("close",s),h.removeListener("upgrading",c)}a('probing transport "%s"',t);var u=this.createTransport(t,{probe:1}),f=!1,h=this;n.priorWebsocketSuccess=!1,u.once("open",e),u.once("error",o),u.once("close",i),this.once("close",s),this.once("upgrading",c),u.open()},n.prototype.onOpen=function(){if(a("socket open"),this.readyState="open",n.priorWebsocketSuccess="websocket"==this.transport.name,this.emit("open"),this.flush(),"open"==this.readyState&&this.upgrade&&this.transport.pause){a("starting upgrade probes");for(var t=0,e=this.upgrades.length;e>t;t++)this.probe(this.upgrades[t])}},n.prototype.onPacket=function(t){if("opening"==this.readyState||"open"==this.readyState)switch(a('socket receive: type "%s", data "%s"',t.type,t.data),this.emit("packet",t),this.emit("heartbeat"),t.type){case"open":this.onHandshake(f(t.data));break;case"pong":this.setPing();break;case"error":var e=new Error("server error");e.code=t.data,this.emit("error",e);break;case"message":this.emit("data",t.data),this.emit("message",t.data)}else a('packet received with socket readyState "%s"',this.readyState)},n.prototype.onHandshake=function(t){this.emit("handshake",t),this.id=t.sid,this.transport.query.sid=t.sid,this.upgrades=this.filterUpgrades(t.upgrades),this.pingInterval=t.pingInterval,this.pingTimeout=t.pingTimeout,this.onOpen(),"closed"!=this.readyState&&(this.setPing(),this.removeListener("heartbeat",this.onHeartbeat),this.on("heartbeat",this.onHeartbeat))},n.prototype.onHeartbeat=function(t){clearTimeout(this.pingTimeoutTimer);var e=this;e.pingTimeoutTimer=setTimeout(function(){"closed"!=e.readyState&&e.onClose("ping timeout")},t||e.pingInterval+e.pingTimeout)},n.prototype.setPing=function(){var t=this;clearTimeout(t.pingIntervalTimer),t.pingIntervalTimer=setTimeout(function(){a("writing ping packet - expecting pong within %sms",t.pingTimeout),t.ping(),t.onHeartbeat(t.pingTimeout)},t.pingInterval)},n.prototype.ping=function(){this.sendPacket("ping")},n.prototype.onDrain=function(){for(var t=0;t<this.prevBufferLen;t++)this.callbackBuffer[t]&&this.callbackBuffer[t]();this.writeBuffer.splice(0,this.prevBufferLen),this.callbackBuffer.splice(0,this.prevBufferLen),this.prevBufferLen=0,0==this.writeBuffer.length?this.emit("drain"):this.flush()},n.prototype.flush=function(){"closed"!=this.readyState&&this.transport.writable&&!this.upgrading&&this.writeBuffer.length&&(a("flushing %d packets in socket",this.writeBuffer.length),this.transport.send(this.writeBuffer),this.prevBufferLen=this.writeBuffer.length,this.emit("flush"))},n.prototype.write=n.prototype.send=function(t,e){return this.sendPacket("message",t,e),this},n.prototype.sendPacket=function(t,e,n){var r={type:t,data:e};this.emit("packetCreate",r),this.writeBuffer.push(r),this.callbackBuffer.push(n),this.flush()},n.prototype.close=function(){return("opening"==this.readyState||"open"==this.readyState)&&(this.onClose("forced close"),a("socket closing - telling transport to close"),this.transport.close()),this},n.prototype.onError=function(t){a("socket error %j",t),n.priorWebsocketSuccess=!1,this.emit("error",t),this.onClose("transport error",t)},n.prototype.onClose=function(t,e){if("opening"==this.readyState||"open"==this.readyState){a('socket close with reason: "%s"',t);var n=this;clearTimeout(this.pingIntervalTimer),clearTimeout(this.pingTimeoutTimer),setTimeout(function(){n.writeBuffer=[],n.callbackBuffer=[],n.prevBufferLen=0},0),this.transport.removeAllListeners("close"),this.transport.close(),this.transport.removeAllListeners(),this.readyState="closed",this.id=null,this.emit("close",t,e)}},n.prototype.filterUpgrades=function(t){for(var e=[],n=0,r=t.length;r>n;n++)~c(this.transports,t[n])&&e.push(t[n]);return e}},{"./transport":14,"./transports":15,"component-emitter":8,debug:9,"engine.io-parser":22,indexof:36,parsejson:29,parseqs:30,parseuri:38}],14:[function(t,e){function n(t){this.path=t.path,this.hostname=t.hostname,this.port=t.port,this.secure=t.secure,this.query=t.query,this.timestampParam=t.timestampParam,this.timestampRequests=t.timestampRequests,this.readyState="",this.agent=t.agent||!1,this.socket=t.socket}var r=t("engine.io-parser"),o=t("component-emitter");e.exports=n,o(n.prototype),n.timestamps=0,n.prototype.onError=function(t,e){var n=new Error(t);return n.type="TransportError",n.description=e,this.emit("error",n),this},n.prototype.open=function(){return("closed"==this.readyState||""==this.readyState)&&(this.readyState="opening",this.doOpen()),this},n.prototype.close=function(){return("opening"==this.readyState||"open"==this.readyState)&&(this.doClose(),this.onClose()),this},n.prototype.send=function(t){if("open"!=this.readyState)throw new Error("Transport not open");this.write(t)},n.prototype.onOpen=function(){this.readyState="open",this.writable=!0,this.emit("open")},n.prototype.onData=function(t){try{var e=r.decodePacket(t,this.socket.binaryType);this.onPacket(e)}catch(n){n.data=t,this.onError("parser decode error",n)}},n.prototype.onPacket=function(t){this.emit("packet",t)},n.prototype.onClose=function(){this.readyState="closed",this.emit("close")}},{"component-emitter":8,"engine.io-parser":22}],15:[function(t,e,n){function r(t){var e,n=!1;if(o.location){var r="https:"==location.protocol,c=location.port;c||(c=r?443:80),n=t.hostname!=location.hostname||c!=t.port}return t.xdomain=n,e=new i(t),"open"in e&&!t.forceJSONP?new s(t):new a(t)}var o="undefined"!=typeof self?self:"undefined"!=typeof window?window:{},i=t("xmlhttprequest"),s=t("./polling-xhr"),a=t("./polling-jsonp"),c=t("./websocket");n.polling=r,n.websocket=c},{"./polling-jsonp":16,"./polling-xhr":17,"./websocket":19,xmlhttprequest:20}],16:[function(t,e){function n(){}function r(t){i.call(this,t),this.query=this.query||{},a||(o.___eio||(o.___eio=[]),a=o.___eio),this.index=a.length;var e=this;a.push(function(t){e.onData(t)}),this.query.j=this.index,o.document&&o.addEventListener&&o.addEventListener("beforeunload",function(){e.script&&(e.script.onerror=n)})}var o="undefined"!=typeof self?self:"undefined"!=typeof window?window:{},i=t("./polling"),s=t("component-inherit");e.exports=r;var a,c=/\n/g,p=/\\n/g;s(r,i),r.prototype.supportsBinary=!1,r.prototype.doClose=function(){this.script&&(this.script.parentNode.removeChild(this.script),this.script=null),this.form&&(this.form.parentNode.removeChild(this.form),this.form=null),i.prototype.doClose.call(this)},r.prototype.doPoll=function(){var t=this,e=document.createElement("script");this.script&&(this.script.parentNode.removeChild(this.script),this.script=null),e.async=!0,e.src=this.uri(),e.onerror=function(e){t.onError("jsonp poll error",e)};var n=document.getElementsByTagName("script")[0];n.parentNode.insertBefore(e,n),this.script=e;var r="undefined"!=typeof navigator&&/gecko/i.test(navigator.userAgent);r&&setTimeout(function(){var t=document.createElement("iframe");document.body.appendChild(t),document.body.removeChild(t)},100)},r.prototype.doWrite=function(t,e){function n(){r(),e()}function r(){if(o.iframe)try{o.form.removeChild(o.iframe)}catch(t){o.onError("jsonp polling iframe removal error",t)}try{var e='<iframe src="javascript:0" name="'+o.iframeId+'">';i=document.createElement(e)}catch(t){i=document.createElement("iframe"),i.name=o.iframeId,i.src="javascript:0"}i.id=o.iframeId,o.form.appendChild(i),o.iframe=i}var o=this;if(!this.form){var i,s=document.createElement("form"),a=document.createElement("textarea"),u=this.iframeId="eio_iframe_"+this.index;s.className="socketio",s.style.position="absolute",s.style.top="-1000px",s.style.left="-1000px",s.target=u,s.method="POST",s.setAttribute("accept-charset","utf-8"),a.name="d",s.appendChild(a),document.body.appendChild(s),this.form=s,this.area=a}this.form.action=this.uri(),r(),t=t.replace(p,"\\\n"),this.area.value=t.replace(c,"\\n");try{this.form.submit()}catch(f){}this.iframe.attachEvent?this.iframe.onreadystatechange=function(){"complete"==o.iframe.readyState&&n()}:this.iframe.onload=n}},{"./polling":18,"component-inherit":21}],17:[function(t,e){function n(){}function r(t){if(c.call(this,t),s.location){var e="https:"==location.protocol,n=location.port;n||(n=e?443:80),this.xd=t.hostname!=s.location.hostname||n!=t.port}}function o(t){this.method=t.method||"GET",this.uri=t.uri,this.xd=!!t.xd,this.async=!1!==t.async,this.data=void 0!=t.data?t.data:null,this.agent=t.agent,this.create(t.isBinary,t.supportsBinary)}function i(){for(var t in o.requests)o.requests.hasOwnProperty(t)&&o.requests[t].abort()}var s="undefined"!=typeof self?self:"undefined"!=typeof window?window:{},a=t("xmlhttprequest"),c=t("./polling"),p=t("component-emitter"),u=t("component-inherit"),f=t("debug")("engine.io-client:polling-xhr");e.exports=r,e.exports.Request=o,u(r,c),r.prototype.supportsBinary=!0,r.prototype.request=function(t){return t=t||{},t.uri=this.uri(),t.xd=this.xd,t.agent=this.agent||!1,t.supportsBinary=this.supportsBinary,new o(t)},r.prototype.doWrite=function(t,e){var n="string"!=typeof t&&void 0!==t,r=this.request({method:"POST",data:t,isBinary:n}),o=this;r.on("success",e),r.on("error",function(t){o.onError("xhr post error",t)}),this.sendXhr=r},r.prototype.doPoll=function(){f("xhr poll");var t=this.request(),e=this;t.on("data",function(t){e.onData(t)}),t.on("error",function(t){e.onError("xhr poll error",t)}),this.pollXhr=t},p(o.prototype),o.prototype.create=function(t,e){var n=this.xhr=new a({agent:this.agent,xdomain:this.xd}),r=this;try{if(f("xhr open %s: %s",this.method,this.uri),n.open(this.method,this.uri,this.async),e&&(n.responseType="arraybuffer"),"POST"==this.method)try{t?n.setRequestHeader("Content-type","application/octet-stream"):n.setRequestHeader("Content-type","text/plain;charset=UTF-8")}catch(i){}"withCredentials"in n&&(n.withCredentials=!0),n.onreadystatechange=function(){var t;try{if(4!=n.readyState)return;if(200==n.status||1223==n.status){var o=n.getResponseHeader("Content-Type");t="application/octet-stream"===o?n.response:e?"ok":n.responseText}else setTimeout(function(){r.onError(n.status)},0)}catch(i){r.onError(i)}null!=t&&r.onData(t)},f("xhr data %s",this.data),n.send(this.data)}catch(i){return void setTimeout(function(){r.onError(i)},0)}s.document&&(this.index=o.requestsCount++,o.requests[this.index]=this)},o.prototype.onSuccess=function(){this.emit("success"),this.cleanup()},o.prototype.onData=function(t){this.emit("data",t),this.onSuccess()},o.prototype.onError=function(t){this.emit("error",t),this.cleanup()},o.prototype.cleanup=function(){if("undefined"!=typeof this.xhr&&null!==this.xhr){this.xhr.onreadystatechange=n;try{this.xhr.abort()}catch(t){}s.document&&delete o.requests[this.index],this.xhr=null}},o.prototype.abort=function(){this.cleanup()},s.document&&(o.requestsCount=0,o.requests={},s.attachEvent?s.attachEvent("onunload",i):s.addEventListener&&s.addEventListener("beforeunload",i))},{"./polling":18,"component-emitter":8,"component-inherit":21,debug:9,xmlhttprequest:20}],18:[function(t,e){function n(t){var e=t&&t.forceBase64;(!c||e)&&(this.supportsBinary=!1),r.call(this,t)}var r=t("../transport"),o=t("parseqs"),i=t("engine.io-parser"),s=t("component-inherit"),a=t("debug")("engine.io-client:polling");e.exports=n;var c=function(){var e=t("xmlhttprequest"),n=new e({agent:this.agent,xdomain:!1});return null!=n.responseType}();s(n,r),n.prototype.name="polling",n.prototype.doOpen=function(){this.poll()},n.prototype.pause=function(t){function e(){a("paused"),n.readyState="paused",t()}var n=this;if(this.readyState="pausing",this.polling||!this.writable){var r=0;this.polling&&(a("we are currently polling - waiting to pause"),r++,this.once("pollComplete",function(){a("pre-pause polling complete"),--r||e()})),this.writable||(a("we are currently writing - waiting to pause"),r++,this.once("drain",function(){a("pre-pause writing complete"),--r||e()}))}else e()},n.prototype.poll=function(){a("polling"),this.polling=!0,this.doPoll(),this.emit("poll")},n.prototype.onData=function(t){var e=this;a("polling got data %s",t);var n=function(t){return"opening"==e.readyState&&e.onOpen(),"close"==t.type?(e.onClose(),!1):void e.onPacket(t)};i.decodePayload(t,this.socket.binaryType,n),"closed"!=this.readyState&&(this.polling=!1,this.emit("pollComplete"),"open"==this.readyState?this.poll():a('ignoring poll - transport state "%s"',this.readyState))},n.prototype.doClose=function(){function t(){a("writing close packet"),e.write([{type:"close"}])}var e=this;"open"==this.readyState?(a("transport open - closing"),t()):(a("transport not open - deferring close"),this.once("open",t))},n.prototype.write=function(t){var e=this;this.writable=!1;var n=function(){e.writable=!0,e.emit("drain")},e=this;i.encodePayload(t,this.supportsBinary,function(t){e.doWrite(t,n)})},n.prototype.uri=function(){var t=this.query||{},e=this.secure?"https":"http",n="";return!1!==this.timestampRequests&&(t[this.timestampParam]=+new Date+"-"+r.timestamps++),this.supportsBinary||t.sid||(t.b64=1),t=o.encode(t),this.port&&("https"==e&&443!=this.port||"http"==e&&80!=this.port)&&(n=":"+this.port),t.length&&(t="?"+t),e+"://"+this.hostname+n+this.path+t}},{"../transport":14,"component-inherit":21,debug:9,"engine.io-parser":22,parseqs:30,xmlhttprequest:20}],19:[function(t,e){function n(t){var e=t&&t.forceBase64;e&&(this.supportsBinary=!1),r.call(this,t)}var r=t("../transport"),o=t("engine.io-parser"),i=t("parseqs"),s=t("component-inherit"),a=t("debug")("engine.io-client:websocket"),c=t("ws");e.exports=n,s(n,r),n.prototype.name="websocket",n.prototype.supportsBinary=!0,n.prototype.doOpen=function(){if(this.check()){var t=this.uri(),e=void 0,n={agent:this.agent};this.ws=new c(t,e,n),void 0===this.ws.binaryType&&(this.supportsBinary=!1),this.ws.binaryType="arraybuffer",this.addEventListeners()
}},n.prototype.addEventListeners=function(){var t=this;this.ws.onopen=function(){t.onOpen()},this.ws.onclose=function(){t.onClose()},this.ws.onmessage=function(e){t.onData(e.data)},this.ws.onerror=function(e){t.onError("websocket error",e)}},"undefined"!=typeof navigator&&/iPad|iPhone|iPod/i.test(navigator.userAgent)&&(n.prototype.onData=function(t){var e=this;setTimeout(function(){r.prototype.onData.call(e,t)},0)}),n.prototype.write=function(t){function e(){n.writable=!0,n.emit("drain")}var n=this;this.writable=!1;for(var r=0,i=t.length;i>r;r++)o.encodePacket(t[r],this.supportsBinary,function(t){try{n.ws.send(t)}catch(e){a("websocket closed before onclose event")}});setTimeout(e,0)},n.prototype.onClose=function(){r.prototype.onClose.call(this)},n.prototype.doClose=function(){"undefined"!=typeof this.ws&&this.ws.close()},n.prototype.uri=function(){var t=this.query||{},e=this.secure?"wss":"ws",n="";return this.port&&("wss"==e&&443!=this.port||"ws"==e&&80!=this.port)&&(n=":"+this.port),this.timestampRequests&&(t[this.timestampParam]=+new Date),this.supportsBinary||(t.b64=1),t=i.encode(t),t.length&&(t="?"+t),e+"://"+this.hostname+n+this.path+t},n.prototype.check=function(){return!(!c||"__initialize"in c&&this.name===n.prototype.name)}},{"../transport":14,"component-inherit":21,debug:9,"engine.io-parser":22,parseqs:30,ws:31}],20:[function(t,e){var n=t("has-cors");e.exports=function(t){var e=t.xdomain;try{if("undefined"!=typeof XMLHttpRequest&&(!e||n))return new XMLHttpRequest}catch(r){}if(!e)try{return new ActiveXObject("Microsoft.XMLHTTP")}catch(r){}}},{"has-cors":34}],21:[function(t,e){e.exports=function(t,e){var n=function(){};n.prototype=e.prototype,t.prototype=new n,t.prototype.constructor=t}},{}],22:[function(t,e,n){function r(t,e,r){if(!e)return n.encodeBase64Packet(t,r);var o=t.data,i=new Uint8Array(o),s=new Uint8Array(1+o.byteLength);s[0]=d[t.type];for(var a=0;a<i.length;a++)s[a+1]=i[a];return r(s.buffer)}function o(t,e,r){if(!e)return n.encodeBase64Packet(t,r);var o=new FileReader;return o.onload=function(){t.data=o.result,n.encodePacket(t,e,r)},o.readAsArrayBuffer(t.data)}function i(t,e,r){if(!e)return n.encodeBase64Packet(t,r);if(l)return o(t,e,r);var i=new Uint8Array(1);i[0]=d[t.type];var s=new m([i.buffer,t.data]);return r(s)}function s(t,e,n){for(var r=new Array(t.length),o=f(t.length,n),i=function(t,n,o){e(n,function(e,n){r[t]=n,o(e,r)})},s=0;s<t.length;s++)i(s,t[s],o)}var a="undefined"!=typeof self?self:"undefined"!=typeof window?window:{},c=t("./keys"),p=t("arraybuffer.slice"),u=t("base64-arraybuffer"),f=t("after"),h=t("utf8"),l=navigator.userAgent.match(/Android/i);n.protocol=2;var d=n.packets={open:0,close:1,ping:2,pong:3,message:4,upgrade:5,noop:6},y=c(d),g={type:"error",data:"parser error"},m=t("blob");n.encodePacket=function(t,e,n){"function"==typeof e&&(n=e,e=!1);var o=void 0===t.data?void 0:t.data.buffer||t.data;if(a.ArrayBuffer&&o instanceof ArrayBuffer)return r(t,e,n);if(m&&o instanceof a.Blob)return i(t,e,n);var s=d[t.type];return void 0!==t.data&&(s+=h.encode(String(t.data))),n(""+s)},n.encodeBase64Packet=function(t,e){var r="b"+n.packets[t.type];if(m&&t.data instanceof m){var o=new FileReader;return o.onload=function(){var t=o.result.split(",")[1];e(r+t)},o.readAsDataURL(t.data)}var i;try{i=String.fromCharCode.apply(null,new Uint8Array(t.data))}catch(s){for(var c=new Uint8Array(t.data),p=new Array(c.length),u=0;u<c.length;u++)p[u]=c[u];i=String.fromCharCode.apply(null,p)}return r+=a.btoa(i),e(r)},n.decodePacket=function(t,e){if("string"==typeof t||void 0===t){if("b"==t.charAt(0))return n.decodeBase64Packet(t.substr(1),e);t=h.decode(t);var r=t.charAt(0);return Number(r)==r&&y[r]?t.length>1?{type:y[r],data:t.substring(1)}:{type:y[r]}:g}var o=new Uint8Array(t),r=o[0],i=p(t,1);return m&&"blob"===e&&(i=new m([i])),{type:y[r],data:i}},n.decodeBase64Packet=function(t,e){var n=y[t.charAt(0)];if(!a.ArrayBuffer)return{type:n,data:{base64:!0,data:t.substr(1)}};var r=u.decode(t.substr(1));return"blob"===e&&m&&(r=new m([r])),{type:n,data:r}},n.encodePayload=function(t,e,r){function o(t){return t.length+":"+t}function i(t,r){n.encodePacket(t,e,function(t){r(null,o(t))})}return"function"==typeof e&&(r=e,e=null),e?m&&!l?n.encodePayloadAsBlob(t,r):n.encodePayloadAsArrayBuffer(t,r):t.length?void s(t,i,function(t,e){return r(e.join(""))}):r("0:")},n.decodePayload=function(t,e,r){if("string"!=typeof t)return n.decodePayloadAsBinary(t,e,r);"function"==typeof e&&(r=e,e=null);var o;if(""==t)return r(g,0,1);for(var i,s,a="",c=0,p=t.length;p>c;c++){var u=t.charAt(c);if(":"!=u)a+=u;else{if(""==a||a!=(i=Number(a)))return r(g,0,1);if(s=t.substr(c+1,i),a!=s.length)return r(g,0,1);if(s.length){if(o=n.decodePacket(s,e),g.type==o.type&&g.data==o.data)return r(g,0,1);var f=r(o,c+i,p);if(!1===f)return}c+=i,a=""}}return""!=a?r(g,0,1):void 0},n.encodePayloadAsArrayBuffer=function(t,e){function r(t,e){n.encodePacket(t,!0,function(t){return e(null,t)})}return t.length?void s(t,r,function(t,n){var r=n.reduce(function(t,e){var n;return n="string"==typeof e?e.length:e.byteLength,t+n.toString().length+n+2},0),o=new Uint8Array(r),i=0;return n.forEach(function(t){var e="string"==typeof t,n=t;if(e){for(var r=new Uint8Array(t.length),s=0;s<t.length;s++)r[s]=t.charCodeAt(s);n=r.buffer}o[i++]=e?0:1;for(var a=n.byteLength.toString(),s=0;s<a.length;s++)o[i++]=parseInt(a[s]);o[i++]=255;for(var r=new Uint8Array(n),s=0;s<r.length;s++)o[i++]=r[s]}),e(o.buffer)}):e(new ArrayBuffer(0))},n.encodePayloadAsBlob=function(t,e){function r(t,e){n.encodePacket(t,!0,function(t){var n=new Uint8Array(1);if(n[0]=1,"string"==typeof t){for(var r=new Uint8Array(t.length),o=0;o<t.length;o++)r[o]=t.charCodeAt(o);t=r.buffer,n[0]=0}for(var i=t instanceof ArrayBuffer?t.byteLength:t.size,s=i.toString(),a=new Uint8Array(s.length+1),o=0;o<s.length;o++)a[o]=parseInt(s[o]);if(a[s.length]=255,m){var c=new m([n.buffer,a.buffer,t]);e(null,c)}})}s(t,r,function(t,n){return e(new m(n))})},n.decodePayloadAsBinary=function(t,e,r){"function"==typeof e&&(r=e,e=null);for(var o=t,i=[];o.byteLength>0;){for(var s=new Uint8Array(o),a=0===s[0],c="",u=1;255!=s[u];u++)c+=s[u];o=p(o,2+c.length),c=parseInt(c);var f=p(o,0,c);if(a)try{f=String.fromCharCode.apply(null,new Uint8Array(f))}catch(h){var l=new Uint8Array(f);f="";for(var u=0;u<l.length;u++)f+=String.fromCharCode(l[u])}i.push(f),o=p(o,c)}var d=i.length;i.forEach(function(t,o){r(n.decodePacket(t,e),o,d)})}},{"./keys":23,after:24,"arraybuffer.slice":25,"base64-arraybuffer":26,blob:27,utf8:28}],23:[function(t,e){e.exports=Object.keys||function(t){var e=[],n=Object.prototype.hasOwnProperty;for(var r in t)n.call(t,r)&&e.push(r);return e}},{}],24:[function(t,e){function n(t,e,n){function o(t,r){if(o.count<=0)throw new Error("after called too many times");--o.count,t?(i=!0,e(t),e=n):0!==o.count||i||e(null,r)}var i=!1;return n=n||r,o.count=t,0===t?e():o}function r(){}e.exports=n},{}],25:[function(t,e){e.exports=function(t,e,n){var r=t.byteLength;if(e=e||0,n=n||r,t.slice)return t.slice(e,n);if(0>e&&(e+=r),0>n&&(n+=r),n>r&&(n=r),e>=r||e>=n||0===r)return new ArrayBuffer(0);for(var o=new Uint8Array(t),i=new Uint8Array(n-e),s=e,a=0;n>s;s++,a++)i[a]=o[s];return i.buffer}},{}],26:[function(t,e,n){!function(t){"use strict";n.encode=function(e){var n,r=new Uint8Array(e),o=r.length,i="";for(n=0;o>n;n+=3)i+=t[r[n]>>2],i+=t[(3&r[n])<<4|r[n+1]>>4],i+=t[(15&r[n+1])<<2|r[n+2]>>6],i+=t[63&r[n+2]];return o%3===2?i=i.substring(0,i.length-1)+"=":o%3===1&&(i=i.substring(0,i.length-2)+"=="),i},n.decode=function(e){var n,r,o,i,s,a=.75*e.length,c=e.length,p=0;"="===e[e.length-1]&&(a--,"="===e[e.length-2]&&a--);var u=new ArrayBuffer(a),f=new Uint8Array(u);for(n=0;c>n;n+=4)r=t.indexOf(e[n]),o=t.indexOf(e[n+1]),i=t.indexOf(e[n+2]),s=t.indexOf(e[n+3]),f[p++]=r<<2|o>>4,f[p++]=(15&o)<<4|i>>2,f[p++]=(3&i)<<6|63&s;return u}}("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/")},{}],27:[function(t,e){function n(t,e){e=e||{};for(var n=new o,r=0;r<t.length;r++)n.append(t[r]);return e.type?n.getBlob(e.type):n.getBlob()}var r="undefined"!=typeof self?self:"undefined"!=typeof window?window:{},o=r.BlobBuilder||r.WebKitBlobBuilder||r.MSBlobBuilder||r.MozBlobBuilder,i=function(){try{var t=new Blob(["hi"]);return 2==t.size}catch(e){return!1}}(),s=o&&o.prototype.append&&o.prototype.getBlob;e.exports=function(){return i?r.Blob:s?n:void 0}()},{}],28:[function(e,n,r){var o="undefined"!=typeof self?self:"undefined"!=typeof window?window:{};!function(e){function i(t){for(var e,n,r=[],o=0,i=t.length;i>o;)e=t.charCodeAt(o++),e>=55296&&56319>=e&&i>o?(n=t.charCodeAt(o++),56320==(64512&n)?r.push(((1023&e)<<10)+(1023&n)+65536):(r.push(e),o--)):r.push(e);return r}function s(t){for(var e,n=t.length,r=-1,o="";++r<n;)e=t[r],e>65535&&(e-=65536,o+=b(e>>>10&1023|55296),e=56320|1023&e),o+=b(e);return o}function a(t,e){return b(t>>e&63|128)}function c(t){if(0==(4294967168&t))return b(t);var e="";return 0==(4294965248&t)?e=b(t>>6&31|192):0==(4294901760&t)?(e=b(t>>12&15|224),e+=a(t,6)):0==(4292870144&t)&&(e=b(t>>18&7|240),e+=a(t,12),e+=a(t,6)),e+=b(63&t|128)}function p(t){for(var e,n=i(t),r=n.length,o=-1,s="";++o<r;)e=n[o],s+=c(e);return s}function u(){if(v>=m)throw Error("Invalid byte index");var t=255&g[v];if(v++,128==(192&t))return 63&t;throw Error("Invalid continuation byte")}function f(){var t,e,n,r,o;if(v>m)throw Error("Invalid byte index");if(v==m)return!1;if(t=255&g[v],v++,0==(128&t))return t;if(192==(224&t)){var e=u();if(o=(31&t)<<6|e,o>=128)return o;throw Error("Invalid continuation byte")}if(224==(240&t)){if(e=u(),n=u(),o=(15&t)<<12|e<<6|n,o>=2048)return o;throw Error("Invalid continuation byte")}if(240==(248&t)&&(e=u(),n=u(),r=u(),o=(15&t)<<18|e<<12|n<<6|r,o>=65536&&1114111>=o))return o;throw Error("Invalid UTF-8 detected")}function h(t){g=i(t),m=g.length,v=0;for(var e,n=[];(e=f())!==!1;)n.push(e);return s(n)}var l="object"==typeof r&&r,d="object"==typeof n&&n&&n.exports==l&&n,y="object"==typeof o&&o;(y.global===y||y.window===y)&&(e=y);var g,m,v,b=String.fromCharCode,w={version:"2.0.0",encode:p,decode:h};if("function"==typeof t&&"object"==typeof t.amd&&t.amd)t(function(){return w});else if(l&&!l.nodeType)if(d)d.exports=w;else{var k={},A=k.hasOwnProperty;for(var B in w)A.call(w,B)&&(l[B]=w[B])}else e.utf8=w}(this)},{}],29:[function(t,e){var n="undefined"!=typeof self?self:"undefined"!=typeof window?window:{},r=/^[\],:{}\s]*$/,o=/\\(?:["\\\/bfnrt]|u[0-9a-fA-F]{4})/g,i=/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g,s=/(?:^|:|,)(?:\s*\[)+/g,a=/^\s+/,c=/\s+$/;e.exports=function(t){return"string"==typeof t&&t?(t=t.replace(a,"").replace(c,""),n.JSON&&JSON.parse?JSON.parse(t):r.test(t.replace(o,"@").replace(i,"]").replace(s,""))?new Function("return "+t)():void 0):null}},{}],30:[function(t,e,n){n.encode=function(t){var e="";for(var n in t)t.hasOwnProperty(n)&&(e.length&&(e+="&"),e+=encodeURIComponent(n)+"="+encodeURIComponent(t[n]));return e},n.decode=function(t){for(var e={},n=t.split("&"),r=0,o=n.length;o>r;r++){var i=n[r].split("=");e[decodeURIComponent(i[0])]=decodeURIComponent(i[1])}return e}},{}],31:[function(t,e){function n(t,e){var n;return n=e?new o(t,e):new o(t)}var r=function(){return this}(),o=r.WebSocket||r.MozWebSocket;e.exports=o?n:null,o&&(n.prototype=o.prototype)},{}],32:[function(t,e){function n(t){function e(t){if(!t)return!1;if(r.Buffer&&Buffer.isBuffer(t)||r.ArrayBuffer&&t instanceof ArrayBuffer||r.Blob&&t instanceof Blob||r.File&&t instanceof File)return!0;if(o(t)){for(var n=0;n<t.length;n++)if(e(t[n]))return!0}else if(t&&"object"==typeof t){t.toJSON&&(t=t.toJSON());for(var i in t)if(e(t[i]))return!0}return!1}return e(t)}var r="undefined"!=typeof self?self:"undefined"!=typeof window?window:{},o=t("isarray");e.exports=n},{isarray:33}],33:[function(t,e){e.exports=Array.isArray||function(t){return"[object Array]"==Object.prototype.toString.call(t)}},{}],34:[function(t,e){var n=t("global");try{e.exports="XMLHttpRequest"in n&&"withCredentials"in new n.XMLHttpRequest}catch(r){e.exports=!1}},{global:35}],35:[function(t,e){e.exports=function(){return this}()},{}],36:[function(t,e){var n=[].indexOf;e.exports=function(t,e){if(n)return t.indexOf(e);for(var r=0;r<t.length;++r)if(t[r]===e)return r;return-1}},{}],37:[function(t,e,n){var r=Object.prototype.hasOwnProperty;n.keys=Object.keys||function(t){var e=[];for(var n in t)r.call(t,n)&&e.push(n);return e},n.values=function(t){var e=[];for(var n in t)r.call(t,n)&&e.push(t[n]);return e},n.merge=function(t,e){for(var n in e)r.call(e,n)&&(t[n]=e[n]);return t},n.length=function(t){return n.keys(t).length},n.isEmpty=function(t){return 0==n.length(t)}},{}],38:[function(t,e){var n=/^(?:(?![^:@]+:[^:@\/]*@)(http|https|ws|wss):\/\/)?((?:(([^:@]*)(?::([^:@]*))?)?@)?((?:[a-f0-9]{0,4}:){2,7}[a-f0-9]{0,4}|[^:\/?#]*)(?::(\d*))?)(((\/(?:[^?#](?![^?#\/]*\.[^?#\/.]+(?:[?#]|$)))*\/?)?([^?#\/]*))(?:\?([^#]*))?(?:#(.*))?)/,r=["source","protocol","authority","userInfo","user","password","host","port","relative","path","directory","file","query","anchor"];e.exports=function(t){for(var e=n.exec(t||""),o={},i=14;i--;)o[r[i]]=e[i]||"";return o}},{}],39:[function(t,e,n){function r(t){return o.Buffer&&Buffer.isBuffer(t)||o.ArrayBuffer&&t instanceof ArrayBuffer}var o="undefined"!=typeof self?self:"undefined"!=typeof window?window:{},i=t("isarray");n.deconstructPacket=function(t){function e(t){if(!t)return t;if(o.Buffer&&Buffer.isBuffer(t)||o.ArrayBuffer&&t instanceof ArrayBuffer){var r={_placeholder:!0,num:n.length};return n.push(t),r}if(i(t)){for(var s=new Array(t.length),a=0;a<t.length;a++)s[a]=e(t[a]);return s}if("object"==typeof t&&!(t instanceof Date)){var s={};for(var c in t)s[c]=e(t[c]);return s}return t}var n=[],r=t.data,s=t;return s.data=e(r),s.attachments=n.length,{packet:s,buffers:n}},n.reconstructPacket=function(t,e){function n(t){if(t&&t._placeholder){var r=e[t.num];return r}if(i(t)){for(var o=0;o<t.length;o++)t[o]=n(t[o]);return t}if(t&&"object"==typeof t){for(var s in t)t[s]=n(t[s]);return t}return t}return t.data=n(t.data),t.attachments=void 0,t},n.removeBlobs=function(t,e){function n(t,c,p){if(!t)return t;if(o.Blob&&t instanceof Blob||o.File&&t instanceof File){s++;var u=new FileReader;u.onload=function(){p?p[c]=this.result:a=this.result,--s||e(a)},u.readAsArrayBuffer(t)}if(i(t))for(var f=0;f<t.length;f++)n(t[f],f,t);else if(t&&"object"==typeof t&&!r(t))for(var h in t)n(t[h],h,t)}var s=0,a=t;n(a),s||e(a)}},{isarray:41}],40:[function(t,e,n){function r(){}function o(t){var e="",r=!1;return e+=t.type,(n.BINARY_EVENT==t.type||n.BINARY_ACK==t.type)&&(e+=t.attachments,e+="-"),t.nsp&&"/"!=t.nsp&&(r=!0,e+=t.nsp),null!=t.id&&(r&&(e+=",",r=!1),e+=t.id),null!=t.data&&(r&&(e+=","),e+=h.stringify(t.data)),f("encoded %j as %s",t,e),e}function i(t,e){function n(t){var n=d.deconstructPacket(t),r=o(n.packet),i=n.buffers;i.unshift(r),e(i)}d.removeBlobs(t,n)}function s(){this.reconstructor=null}function a(t){var e={},r=0;if(e.type=Number(t.charAt(0)),null==n.types[e.type])return p();if(n.BINARY_EVENT==e.type||n.BINARY_ACK==e.type){for(e.attachments="";"-"!=t.charAt(++r);)e.attachments+=t.charAt(r);e.attachments=Number(e.attachments)}if("/"==t.charAt(r+1))for(e.nsp="";++r;){var o=t.charAt(r);if(","==o)break;if(e.nsp+=o,r+1==t.length)break}else e.nsp="/";var i=t.charAt(r+1);if(""!=i&&Number(i)==i){for(e.id="";++r;){var o=t.charAt(r);if(null==o||Number(o)!=o){--r;break}if(e.id+=t.charAt(r),r+1==t.length)break}e.id=Number(e.id)}if(t.charAt(++r))try{e.data=h.parse(t.substr(r))}catch(s){return p()}return f("decoded %s as %j",t,e),e}function c(t){this.reconPack=t,this.buffers=[]}function p(){return{type:n.ERROR,data:"parser error"}}var u="undefined"!=typeof self?self:"undefined"!=typeof window?window:{},f=t("debug")("socket.io-parser"),h=t("json3"),l=(t("isarray"),t("emitter")),d=t("./binary");n.protocol=3,n.types=["CONNECT","DISCONNECT","EVENT","BINARY_EVENT","ACK","BINARY_ACK","ERROR"],n.CONNECT=0,n.DISCONNECT=1,n.EVENT=2,n.ACK=3,n.ERROR=4,n.BINARY_EVENT=5,n.BINARY_ACK=6,n.Encoder=r,r.prototype.encode=function(t,e){if(f("encoding packet %j",t),n.BINARY_EVENT==t.type||n.BINARY_ACK==t.type)i(t,e);else{var r=o(t);e([r])}},n.Decoder=s,l(s.prototype),s.prototype.add=function(t){var e;if("string"==typeof t)e=a(t),n.BINARY_EVENT==e.type||n.BINARY_ACK==e.type?(this.reconstructor=new c(e),0==this.reconstructor.reconPack.attachments&&this.emit("decoded",e)):this.emit("decoded",e);else{if(!(u.Buffer&&Buffer.isBuffer(t)||u.ArrayBuffer&&t instanceof ArrayBuffer||t.base64))throw new Error("Unknown type: "+t);if(!this.reconstructor)throw new Error("got binary data when not reconstructing a packet");e=this.reconstructor.takeBinaryData(t),e&&(this.reconstructor=null,this.emit("decoded",e))}},s.prototype.destroy=function(){this.reconstructor&&this.reconstructor.finishedReconstruction()},c.prototype.takeBinaryData=function(t){if(this.buffers.push(t),this.buffers.length==this.reconPack.attachments){var e=d.reconstructPacket(this.reconPack,this.buffers);return this.finishedReconstruction(),e}return null},c.prototype.finishedReconstruction=function(){this.reconPack=null,this.buffers=[]}},{"./binary":39,debug:9,emitter:10,isarray:41,json3:42}],41:[function(t,e){e.exports=t(33)},{}],42:[function(e,n,r){!function(e){function n(t){if(n[t]!==s)return n[t];var e;if("bug-string-char-index"==t)e="a"!="a"[0];else if("json"==t)e=n("json-stringify")&&n("json-parse");else{var r,o='{"a":[1,true,false,null,"\\u0000\\b\\n\\f\\r\\t"]}';if("json-stringify"==t){var i=u.stringify,c="function"==typeof i&&f;if(c){(r=function(){return 1}).toJSON=r;try{c="0"===i(0)&&"0"===i(new Number)&&'""'==i(new String)&&i(a)===s&&i(s)===s&&i()===s&&"1"===i(r)&&"[1]"==i([r])&&"[null]"==i([s])&&"null"==i(null)&&"[null,null,null]"==i([s,a,null])&&i({a:[r,!0,!1,null,"\x00\b\n\f\r	"]})==o&&"1"===i(null,r)&&"[\n 1,\n 2\n]"==i([1,2],null,1)&&'"-271821-04-20T00:00:00.000Z"'==i(new Date(-864e13))&&'"+275760-09-13T00:00:00.000Z"'==i(new Date(864e13))&&'"-000001-01-01T00:00:00.000Z"'==i(new Date(-621987552e5))&&'"1969-12-31T23:59:59.999Z"'==i(new Date(-1))}catch(p){c=!1}}e=c}if("json-parse"==t){var h=u.parse;if("function"==typeof h)try{if(0===h("0")&&!h(!1)){r=h(o);var l=5==r.a.length&&1===r.a[0];if(l){try{l=!h('"	"')}catch(p){}if(l)try{l=1!==h("01")}catch(p){}if(l)try{l=1!==h("1.")}catch(p){}}}}catch(p){l=!1}e=l}}return n[t]=!!e}var o,i,s,a={}.toString,c="function"==typeof t&&t.amd,p="object"==typeof JSON&&JSON,u="object"==typeof r&&r&&!r.nodeType&&r;u&&p?(u.stringify=p.stringify,u.parse=p.parse):u=e.JSON=p||{};var f=new Date(-0xc782b5b800cec);try{f=-109252==f.getUTCFullYear()&&0===f.getUTCMonth()&&1===f.getUTCDate()&&10==f.getUTCHours()&&37==f.getUTCMinutes()&&6==f.getUTCSeconds()&&708==f.getUTCMilliseconds()}catch(h){}if(!n("json")){var l="[object Function]",d="[object Date]",y="[object Number]",g="[object String]",m="[object Array]",v="[object Boolean]",b=n("bug-string-char-index");if(!f)var w=Math.floor,k=[0,31,59,90,120,151,181,212,243,273,304,334],A=function(t,e){return k[e]+365*(t-1970)+w((t-1969+(e=+(e>1)))/4)-w((t-1901+e)/100)+w((t-1601+e)/400)};(o={}.hasOwnProperty)||(o=function(t){var e,n={};return(n.__proto__=null,n.__proto__={toString:1},n).toString!=a?o=function(t){var e=this.__proto__,n=t in(this.__proto__=null,this);return this.__proto__=e,n}:(e=n.constructor,o=function(t){var n=(this.constructor||e).prototype;return t in this&&!(t in n&&this[t]===n[t])}),n=null,o.call(this,t)});var B={"boolean":1,number:1,string:1,undefined:1},x=function(t,e){var n=typeof t[e];return"object"==n?!!t[e]:!B[n]};if(i=function(t,e){var n,r,s,c=0;(n=function(){this.valueOf=0}).prototype.valueOf=0,r=new n;for(s in r)o.call(r,s)&&c++;return n=r=null,c?i=2==c?function(t,e){var n,r={},i=a.call(t)==l;for(n in t)i&&"prototype"==n||o.call(r,n)||!(r[n]=1)||!o.call(t,n)||e(n)}:function(t,e){var n,r,i=a.call(t)==l;for(n in t)i&&"prototype"==n||!o.call(t,n)||(r="constructor"===n)||e(n);(r||o.call(t,n="constructor"))&&e(n)}:(r=["valueOf","toString","toLocaleString","propertyIsEnumerable","isPrototypeOf","hasOwnProperty","constructor"],i=function(t,e){var n,i,s=a.call(t)==l,c=!s&&"function"!=typeof t.constructor&&x(t,"hasOwnProperty")?t.hasOwnProperty:o;for(n in t)s&&"prototype"==n||!c.call(t,n)||e(n);for(i=r.length;n=r[--i];c.call(t,n)&&e(n))console.log("")}),i(t,e)},!n("json-stringify")){var C={92:"\\\\",34:'\\"',8:"\\b",12:"\\f",10:"\\n",13:"\\r",9:"\\t"},_="000000",S=function(t,e){return(_+(e||0)).slice(-t)},E="\\u00",T=function(t){var e,n='"',r=0,o=t.length,i=o>10&&b;for(i&&(e=t.split(""));o>r;r++){var s=t.charCodeAt(r);switch(s){case 8:case 9:case 10:case 12:case 13:case 34:case 92:n+=C[s];break;default:if(32>s){n+=E+S(2,s.toString(16));break}n+=i?e[r]:b?t.charAt(r):t[r]}}return n+'"'},P=function(t,e,n,r,c,p,u){var f,h,l,b,k,B,x,C,_,E,N,O,j,R,q,U;try{f=e[t]}catch(I){}if("object"==typeof f&&f)if(h=a.call(f),h!=d||o.call(f,"toJSON"))"function"==typeof f.toJSON&&(h!=y&&h!=g&&h!=m||o.call(f,"toJSON"))&&(f=f.toJSON(t));else if(f>-1/0&&1/0>f){if(A){for(k=w(f/864e5),l=w(k/365.2425)+1970-1;A(l+1,0)<=k;l++);for(b=w((k-A(l,0))/30.42);A(l,b+1)<=k;b++);k=1+k-A(l,b),B=(f%864e5+864e5)%864e5,x=w(B/36e5)%24,C=w(B/6e4)%60,_=w(B/1e3)%60,E=B%1e3}else l=f.getUTCFullYear(),b=f.getUTCMonth(),k=f.getUTCDate(),x=f.getUTCHours(),C=f.getUTCMinutes(),_=f.getUTCSeconds(),E=f.getUTCMilliseconds();f=(0>=l||l>=1e4?(0>l?"-":"+")+S(6,0>l?-l:l):S(4,l))+"-"+S(2,b+1)+"-"+S(2,k)+"T"+S(2,x)+":"+S(2,C)+":"+S(2,_)+"."+S(3,E)+"Z"}else f=null;if(n&&(f=n.call(e,t,f)),null===f)return"null";if(h=a.call(f),h==v)return""+f;if(h==y)return f>-1/0&&1/0>f?""+f:"null";if(h==g)return T(""+f);if("object"==typeof f){for(R=u.length;R--;)if(u[R]===f)throw TypeError();if(u.push(f),N=[],q=p,p+=c,h==m){for(j=0,R=f.length;R>j;j++)O=P(j,f,n,r,c,p,u),N.push(O===s?"null":O);U=N.length?c?"[\n"+p+N.join(",\n"+p)+"\n"+q+"]":"["+N.join(",")+"]":"[]"}else i(r||f,function(t){var e=P(t,f,n,r,c,p,u);e!==s&&N.push(T(t)+":"+(c?" ":"")+e)}),U=N.length?c?"{\n"+p+N.join(",\n"+p)+"\n"+q+"}":"{"+N.join(",")+"}":"{}";return u.pop(),U}};u.stringify=function(t,e,n){var r,o,i,s;if("function"==typeof e||"object"==typeof e&&e)if((s=a.call(e))==l)o=e;else if(s==m){i={};for(var c,p=0,u=e.length;u>p;c=e[p++],s=a.call(c),(s==g||s==y)&&(i[c]=1))console.log("")}if(n)if((s=a.call(n))==y){if((n-=n%1)>0)for(r="",n>10&&(n=10);r.length<n;r+=" ")console.log("")}else s==g&&(r=n.length<=10?n:n.slice(0,10));return P("",(c={},c[""]=t,c),o,i,r,"",[])}}if(!n("json-parse")){var N,O,j=String.fromCharCode,R={92:"\\",34:'"',47:"/",98:"\b",116:"	",110:"\n",102:"\f",114:"\r"},q=function(){throw N=O=null,SyntaxError()},U=function(){for(var t,e,n,r,o,i=O,s=i.length;s>N;)switch(o=i.charCodeAt(N)){case 9:case 10:case 13:case 32:N++;break;case 123:case 125:case 91:case 93:case 58:case 44:return t=b?i.charAt(N):i[N],N++,t;case 34:for(t="@",N++;s>N;)if(o=i.charCodeAt(N),32>o)q();else if(92==o)switch(o=i.charCodeAt(++N)){case 92:case 34:case 47:case 98:case 116:case 110:case 102:case 114:t+=R[o],N++;break;case 117:for(e=++N,n=N+4;n>N;N++)o=i.charCodeAt(N),o>=48&&57>=o||o>=97&&102>=o||o>=65&&70>=o||q();t+=j("0x"+i.slice(e,N));break;default:q()}else{if(34==o)break;for(o=i.charCodeAt(N),e=N;o>=32&&92!=o&&34!=o;)o=i.charCodeAt(++N);t+=i.slice(e,N)}if(34==i.charCodeAt(N))return N++,t;q();default:if(e=N,45==o&&(r=!0,o=i.charCodeAt(++N)),o>=48&&57>=o){for(48==o&&(o=i.charCodeAt(N+1),o>=48&&57>=o)&&q(),r=!1;s>N&&(o=i.charCodeAt(N),o>=48&&57>=o);N++);if(46==i.charCodeAt(N)){for(n=++N;s>n&&(o=i.charCodeAt(n),o>=48&&57>=o);n++);n==N&&q(),N=n}if(o=i.charCodeAt(N),101==o||69==o){for(o=i.charCodeAt(++N),(43==o||45==o)&&N++,n=N;s>n&&(o=i.charCodeAt(n),o>=48&&57>=o);n++);n==N&&q(),N=n}return+i.slice(e,N)}if(r&&q(),"true"==i.slice(N,N+4))return N+=4,!0;if("false"==i.slice(N,N+5))return N+=5,!1;if("null"==i.slice(N,N+4))return N+=4,null;q()}return"$"},I=function(t){var e,n;if("$"==t&&q(),"string"==typeof t){if("@"==(b?t.charAt(0):t[0]))return t.slice(1);if("["==t){for(e=[];t=U(),"]"!=t;n||(n=!0))n&&(","==t?(t=U(),"]"==t&&q()):q()),","==t&&q(),e.push(I(t));return e}if("{"==t){for(e={};t=U(),"}"!=t;n||(n=!0))n&&(","==t?(t=U(),"}"==t&&q()):q()),(","==t||"string"!=typeof t||"@"!=(b?t.charAt(0):t[0])||":"!=U())&&q(),e[t.slice(1)]=I(U());return e}q()}return t},D=function(t,e,n){var r=L(t,e,n);r===s?delete t[e]:t[e]=r},L=function(t,e,n){var r,o=t[e];if("object"==typeof o&&o)if(a.call(o)==m)for(r=o.length;r--;)D(o,r,n);else i(o,function(t){D(o,t,n)});return n.call(t,e,o)};u.parse=function(t,e){var n,r;return N=0,O=""+t,n=I(U()),"$"!=U()&&q(),N=O=null,e&&a.call(e)==l?L((r={},r[""]=n,r),"",e):n}}}c&&t(function(){return u})}(this)},{}],43:[function(t,e){function n(t,e){var n=[];e=e||0;for(var r=e||0;r<t.length;r++)n[r-e]=t[r];return n}e.exports=n},{}]},{},[1])(1)});﻿/* Last update: 22/03/2019 13:43:18 */var element_vgchat = document.createElement('div');
element_vgchat.id = 'panel_chat_vatgia';
var element_vgchat_ovlay = document.createElement('div');
element_vgchat_ovlay.id = 'vgchat_ovlay';
element_vgchat_ovlay.className = 'vgchat_hide';
var element_vgchat_ovlay_ct = document.createElement('div');
element_vgchat_ovlay_ct.id = 'vgchat_ovlay_ct';
element_vgchat_ovlay_ct.className = 'vgchat_hide';
var body_vgchat = document.getElementsByTagName('body')[0];
body_vgchat.appendChild(element_vgchat);
body_vgchat.appendChild(element_vgchat_ovlay);
body_vgchat.appendChild(element_vgchat_ovlay_ct);
delete body_vgchat;
delete element_vgchat;
delete element_vgchat_ovlay;
delete element_vgchat_ovlay_ct;

/* config bật tiếng khi nhận chat */
var vgc_audio_message = 0;

/* config tự động bật boxchat */
var vgc_auto_boxchat = 1;

/* check tab browser is active or blur */
var vgc_isTabActive = 0;
console.log('Tab active: ', vgc_isTabActive);

/* when excute notification set isShowNotifi = 1, => excute notification isShowNotifi == 1 then return false */
var isShowNotifi = 0;

/* Neu nguoi dung click vao tab trinh duyet */
window.onfocus = function () {
 vgc_isTabActive = 1;
 console.log('Tab focus active: ', vgc_isTabActive);
}

/* Neu nguoi dung roi khoi tab trinh duyet */
window.onblur = function () {
 vgc_isTabActive = 0;
}

/* nếu người dùng move chuột trên màn hình cũng coi là active rồi */
window.onmousemove = function(){
 //vgc_isTabActive = 1;
}

/* Title của website */
var vgc_title = document.title;

/* Tổng số tin nhắn mới đến nếu có */
var vgc_new_msg = 0;

/* Tiêu đề mới cho lần thứ 2 khi có ng chat đến */
var vgc_new_title = '';

/**
 Hàm tạo box chat của user
 +click vào danh sách user trong list chát tạo box chát
*/
var VGCcreateBox = false;

/* Trả lời yêu cầu chat ngay của khach hàng (click vào nút cancel) */
var rep_when_cancel = 0;
var rep_when_cancel_text = '';

/*
 hàm get cookie
 name : tên cookie
*/
function vgc_getCookie(name){
 var value = "; " + document.cookie;
 var parts = value.split("; " + name + "=");
 if (parts.length == 2) return parts.pop().split(";").shift();
}


/*
 hàm set cookie
 obj
 name : tên cookie
 value : giá trị cookie
 expires : thời gian hết hạn
 type : kiểu thời gian (m: phút, d: ngày)
*/
function vgc_setCookie(obj){
 var d = new Date();
 var _name = obj.name || '';
 var _value = obj.value || '';
 var _expire = obj.expires || '';
 var _type = obj.type || 'd';
 var _time = 0;
 if(_type == 'm'){
 _time = (_expire*60*1000);
 }else{
 _time = (_expire*24*60*60*1000);
 }
 d.setTime(d.getTime() +_time );
 var expires = "expires="+d.toUTCString();
 document.cookie = _name + "=" + _value + "; " + expires +';path=/';
}



/**
 Call function config
 : gọi function để show eyechat, greeting :
*/
function call_start_function_client(){
 if(isset(typeof _vcclient_config)){
 /* B1: nếu không có eyechat thì sử dụng greeting new visitor, ưu tiên bật boxchat lên trước rồi mới đến new_visit */
 var greeting_showboxchat = (isset(typeof _vcclient_config.greeting.invite_showbox))? _vcclient_config.greeting.invite_showbox.vl : 0;
 if(greeting_showboxchat == 1){
 var _greeting_time = _vcclient_config.greeting.invite_showbox.time || 1;
 _vcclient.greeting_showboxchat(_greeting_time);
 }
 
 if(isset(typeof _vcclient_config.orther)){
 
 if(isset(typeof _vcclient_config.orther.rep_when_cancel)){
 rep_when_cancel = _vcclient_config.orther.rep_when_cancel.vl;
 rep_when_cancel_text = _vcclient_config.orther.rep_when_cancel.text;
 }
 
 }
 }

}// end function

/*
 config show boxxchat
*/
var _vcclient = {
 
 /* hàm set auto_reply */
 set_answer_auto_reply : function(){
 if(vc_auto_reply == 0) return;
 if(_vcclient_config.autoreply.auto_reply == 1){
 var autoreply_step = parseInt(vgc_getCookie('autoreply_step')) || 1;
 if(autoreply_step > 2) return;
 var data_msg = {
 owner : 'vgc_rowfriend',
 msg : ((autoreply_step == 2)? _vcclient_config.autoreply.auto_reply_second : _vcclient_config.autoreply.auto_reply_first),
 id : $vnpJs('#vgc_to_id').val(),
 };
 if(data_msg.msg != ''){
 vgchatClientAppendMsgToBoxchat(data_msg);
 }
 vgc_setCookie({name : 'autoreply_step', value : (autoreply_step + 1), expires : 1});
 return;
 }
 },
 /* Hàm bật boxchat mới chat đối với khách hàng */
 greeting_showboxchat : function(_time){ 
 if(_time <= 0) _time = _vcclient_config.greeting.invite_showbox.time || 2;
 var greeting_check = _vcclient_config.greeting.invite_showbox.vl || 0;
 /*
 - kiểm tra xem có quyền được dùng chức năng này không => không thì thoát luôn
 - kiểm tra xem đã bật boxchat mấy lần vs gian hàng này
 + lần đầu tiên thì bật boxchat kèm vs tin nhắn mời chat
 + lần thứ 2 trở đi thì chỉ bât boxchat lên thôi
 */
 
 if(isset(typeof vgc_js_permission) && isset(typeof vgc_js_permission.show_boxchat)){
 if(vgc_js_permission.show_boxchat == 0){
 return false;
 }
 }
 
 
 if(greeting_check == 1){
 /* cookie xác nhận bật tin nhắn mời chào đầu tiên */
 if(typeof vgc_estore_id == 'undefined') vgc_estore_id = 0;
 var cc_msg = 'cc_msg_'+vgc_estore_id; 
 var is_show_msg = parseInt(vgc_getCookie(cc_msg)) || 0;
 
 /*is_show_msg 
 = 1 tức là đã bật boxchat kèm tin nhắn rồi chỉ cần bật boxchat lên thôi
 = 0 tức là chưa bật boxchat, cần bật boxchat và gắn luôn tin nhắn đầu tiên vào
 */
 var first_msg = _vcclient_config.greeting.invite_showbox.first_msg || 'Chào bạn! Tôi có thể giúp gì cho bạn?';
 if(is_show_msg == 0){
 setTimeout(function(){
  create_chat_box({id: vgc_estore_id,show_msg : first_msg});
  vgc_setCookie({name:cc_msg, expires:1, value : 1, type : 'd'});
 }, _time * 1000);
 
 }
 else{
 return;
 /* kiểm tra xem boxchat có đang bật không
  = đang bật thì thôi
  = chưa bật thì bật lên
 */
 if($('#bchatvg_'+vgc_estore_id).length){
  if(!$('#bchatvg_'+vgc_estore_id).hasClass('open')){
 $('#bchatvg_'+vgc_estore_id).find('.box_onlyname').find('span').trigger('click');
  }
 }else{
  create_chat_box({id: vgc_estore_id});
 }
 }
 }
 }
 
};


function create_chat_box(obj_box){
 var _id = obj_box.id || 0;
 if(_id <= 0){
 _id = obj_box.use_id || 0;
 }
 
 var is_mobile = obj_box.is_mobile || 0;
 /* chủ động click chat thì bật lên chứ không ẩn đi */
 /*27/4/2016 chiến bỏ tính năng này đi luôn luôn cho bằng 1 để lúc nào cũng bật chat lên*/
 var isshow = 1; /*obj_box.isshow || 0;*/
 
 /* nếu vẫn <= 0 thì thoát luôn */
 if(_id <= 0) return;

 /* callback function before send ajax and end ajax */
 var callback_start = obj_box.callback_start || '';
 var callback_end = obj_box.callback_end || '';


 /* kiểm tra nếu đang là trang help support thì bật box theo kiểu khác */
 if($('#vgc_helpsupport').length){
 getboxchat(obj_box);
 return false;
 }

 obj_box.send_id = obj_box.send_id || 0;
 var vgc_send_id_pn = $('#vgc_send_id_pn').val() || 0;
 if(obj_box.send_id <= 0){
 obj_box.send_id = (vgc_send_id_pn > 0)? vgc_send_id_pn : VatGiaChatReadCookie("chat_guest_id");
 }
 
 /* kiểm tra show boxchat trên trang vatgia kèm theo câu chào */
 show_msg = '';
 if(isset(typeof obj_box.show_msg)){
 if(obj_box.show_msg != '') show_msg = obj_box.show_msg;
 }
 
 /* thêm support id */
 if( isset(typeof vgc_support_id) ){
 obj_box.support_id = vgc_support_id;
 }
 var box_show = $('#showboxchat');
 var count_boxchat = box_show.find('.boxvg').length;
 var obj = $('#boxchat_'+_id);
 var coffline = obj_box.coffline || 0;
 /* kiểm tra box đã có chưa và đang block hay none để hiển thị lên */
 if(box_show.find('#boxchat_'+_id).length <= 0){
 if(!VGCcreateBox){
 VGCcreateBox = true;
 /* Set background color li */
 $('#VgChatListOnline .friend_'+_id).addClass('pnacf');

 /* xóa tin nhắn offline */
 $('#VgChatListOnline .friend_'+ _id + ' .msg_offline').remove();

 /* xóa class mầu đỏ của tên */
 $('#VgChatListOnline .friend_'+ _id +' .pnrowid .name').removeClass('msgoffline_name');

 /* Kiểm tra xem tạo box này có nằm trong feed không nếu có feed thì bắn đi cùng luôn */
 var vgcCheckFeedOnline = $('#vgc_check_feed_online').val() || 0;
 obj_box.feed = vgcCheckFeedOnline;

 if(callback_start != ''){
 window[callback_start]();
 }
 
 
 $.post(
 url_server_chat+"box.php",
 obj_box,
 function(data) {
 if(count_boxchat <= 2){
 $('#showboxchat').prepend(data); 
 }else{
 /* dùng:first-child vì nó là thằng dầu tiên của list (có đoạn phải dụng theo mảng để lấy []) */
 var _name_hide = $(box_show.find('.ac')[0]).find('.box_onlyname span').text();
 var _id_hide = $(box_show.find('.ac')[0]).data('id') || 0;
 $(box_show.find('.ac')[0]).removeClass('ac');
 var count_box_hide = parseInt(box_show.find('.count_box_hide .counts').text()) || 0;
 box_show.find('.count_box_hide .counts').text((count_box_hide+1));
 box_show.find('.count_box_hide').removeClass('hide')
 .show();
 box_show.find('.count_box_hide .name_hide').append('<span id="nameh_'+_id_hide+'" class="name" data-id="'+_id_hide+'" ><i class="subname" onclick="show_hide_boxchat('+_id_hide+', this);">'+_name_hide+'</i><i class="name_hide_icc ic_chat" onclick="close_box_chat('+_id_hide+');"></i><i class="vgc_count_msgoff"></i></span>');

 $('#showboxchat').prepend(data);
 }
 scrollTopBox({to_id:_id});
 if(isset(typeof vgc_auto_boxchat)){
 if(vgc_auto_boxchat == 0 && isshow == 0){
 show_hide_boxchat(_id, obj);
 }
 }
 
 /* Nếu show_mgs != '' tức là cần append tin nhắn vào */
 if(show_msg != ''){
 var _date = new Date();
 var vgc_time = _date.getTime();
 var dataappen = {};
 dataappen.box_id = _id;
 dataappen.owner = 'rowfriend';
 dataappen.msg = show_msg;
 dataappen.vgc_time = vgc_time;
 appendMsgToBoxchat(dataappen);
 }

 VGCcreateBox = false;
 if(callback_end != ''){
 window[callback_end]();
 }
 },
 'html'
 );
 }
 }else{
 /* kiểm tra đang block hay none */
 show_hide_boxchat(_id, obj);
 }

 /* Nếu mà có trong list user chờ chat thì xóa đi */
 if($('#standby_user_'+_id).length){
 $('#standby_user_'+_id).remove();
 if($('#vgc_list_standby_user .vgc_item_user').length<=0){
 $('#vgc_list_standby_user').hide();
 }
 }

 if(isset(typeof ga)) ga('send', 'event', 'Open box chat', 'Click', 'vatgia.com');

 /* xóa html khảo sát ý kiến khi bật boxchat hoặc có boxchat default */
 if($('#polls_vgc').length){
 $('#polls_vgc').remove();
 }

 /* Thêm mới vào array_feed_owner để nhận biết đây là máy tính đầu tiên click chat vs khách hàng */
 /*
 if(isset(typeof array_feed_owner)){
 if( jQuery.inArray( _id, array_feed_owner ) == -1 ){
 array_feed_owner.push( parseInt(_id) );
 }
 }
 */
}

/**
 Ẩn hiện box chat khi click vào tên (name), và phần tên (160px khi được ẩn xuống)
 +click vào name trên header của box chát
 +clicl vào name only của box chát
*/
function show_hide_boxchat(id, obj){
 if(parseInt(id) > 0){
 var boxvg_parent = $('#boxchat_'+id).parent();
 var boxvg = $('#boxchat_'+id);
 var ststus = 1;

 if(!boxvg_parent.hasClass('ac')){
 var box_show = $('#showboxchat');
 /* phải dung theo mảng vì :first-child nó sẽ lấy item đàu tiên của list sẽ bị sai, phải lấy mảng đầu tiên */
 var _name_hide = $(box_show.find('.ac')[0]).find('.box_onlyname span').text();
 var _id_hide = $(box_show.find('.ac')[0]).data('id') || 0;
 var count_box_hide = parseInt(box_show.find('.count_box_hide .counts').text()) || 0;
 box_show.find('.count_box_hide .name_hide').append('<span id="nameh_'+_id_hide+'" class="name" data-id="'+_id_hide+'" ><i class="subname" onclick="show_hide_boxchat('+_id_hide+', this);">'+_name_hide+'</i><i class="name_hide_icc ic_chat" onclick="close_box_chat('+_id_hide+');"></i><i class="vgc_count_msgoff"></i></span>');
 $(box_show.find('.ac')[0]).removeClass('ac')


 $('.count_box_hide .name_hide #nameh_'+id).remove();
 boxvg_parent.addClass('open')
 .addClass('ac');
 boxvg.show();
 boxvg_parent.find('.box_onlyname').hide();

 /* bỏ số count offline ở phần name hide đi */
 $('#nameh_'+id+' .vgc_count_msgoff').text('0')
 .hide();

 /* xóa class check của chính user này */
 $('#bchatvg_'+id).removeClass('vgc_check_count_msgoff');
 /* nếu không còn class check count msg offline thì bỏ cái hiển thị nháy mầu ở name hide */
 if($('.vgc_check_count_msgoff').length <= 0){
 $('#showboxchat .count_box_hide').removeClass('vgc_activemsg');
 }

 }else{
 /* kiểm tra xem box đang hiện hay ẩn, ẩn thì hiện lên không thì ẩn đi */
 if(boxvg.css('display') == 'block'){
 boxvg.hide();
 boxvg_parent.find('.box_onlyname').show()
 .removeClass('hide');
 boxvg_parent.removeClass('open');
 status = 2;
 }else{
 var objs={};
 objs.to_id = id;
 objs.status = 1;
 vatgiatToggleBoxChat(objs);
 boxvg_parent.find('.box_onlyname').hide()
 .removeClass('active');
 boxvg_parent.addClass('open');
 boxvg.removeClass('hide');
 boxvg.show();

 status = 1;
 }
 }
 }

 /* kéo lại scroll về cuối cùng */
 scrollTopBox({to_id:id});

 /* addhistory để thay thế trạng thái ẩn hiện của box chat */
 var data = {};
 data.status = status;
 data.to_id = id;
 data.pro_id = 0;
 data.count_msg = 0;
 addToHistory(data);
 return false;
}

/**
 Hàm hiển thị / ẩn những user được tạo box chát nhưng quá 3 box bị ẩn đi
 (nút có biểu tượng message)
 +click vào nút msg (chỗ hiển thị những user có box chát bị ẩn)
*/
function show_name_hide(obj){
 var name_hide = $(obj).find('.name_hide');
 if(!name_hide.hasClass('hide')){
 $(obj).css({'border-top':'1px solid #BAC0CD','background-color': '#F0F1F3'});
 name_hide.addClass('hide');
 }else{
 $(obj).css({'border-top':'none','background-color': '#fff'});
 name_hide.removeClass('hide');
 }

}

/**
 function close box chat và hỏi có muốn thoát luôn không
*/
function close_box_chat(id){
 if(parseInt(id) < 0) return;

 /* Kiểm tra nếu là supplier = 1 thì hiển thị thông báo hỏi */
 var supplier = $('#vgc_supplier_'+id).val();
 var poll_after = $('#vgc_poll_after_'+id).val() || 0;
 if(parseInt(poll_after) == 0){
 remove_box_chat(id, this);
 return false;
 }

 if($('#vgc_polls_after_'+id).length){
 if($('#vgc_polls_after_'+id).css('display') == 'block'){
 remove_box_chat(id, this);
 return false;
 }
 var boxvg = $('#boxchat_'+id);
 var boxvg_parent = $('#boxchat_'+id).parent();
 /* kiểm tra xem box đang hiện hay ẩn, ẩn thì hiện lên không thì ẩn đi */
 if(boxvg.css('display') != 'block'){
 var objs={};
 objs.to_id = id;
 objs.status = 1;
 vatgiatToggleBoxChat(objs);
 boxvg_parent.find('.box_onlyname').hide()
 .removeClass('active');
 boxvg_parent.addClass('open');
 boxvg.removeClass('hide');
 boxvg.show();
 status = 1;
 }
 
 /* kiểm tra có cuộc chat mới hiện đánh giá không thì thôi */
 var htm_len = $('#boxchat_'+id+' .rowme').length;
 if(htm_len > 0){
 $('#vgc_polls_after_'+id).html('<div style="text-align:center;padding:20px 0;">Đang tải ...</div>');
 vgc_get_polls_after(id);
 $('#vgc_polls_after_'+id).show();
 }else{
 remove_box_chat(id, this);
 return false;
 }
 }
}

/**
 Hàm remove box chat
 +click vào nút x trên ô header name
 +click vào nút x trên ô name only lúc bị hạ xuống
 +click vào nút x trên phần name (những user đang bị ẩn box chat)
*/
function remove_box_chat(id, obj){
 if(parseInt(id) > 0){
 if($('#bchatvg_'+id).length > 0){
 /* Kiểm tra có phải feed không để xóa feed */
 var vgcCheckFeedOnline = parseInt($('#vgc_check_feed_online').val()) || 0;
 var feed_id = parseInt($('#bchatvg_'+id+' .send_id_vgchat').text()) || 0;
 if(vgcCheckFeedOnline == 1 && feed_id > 0){
 $.post(
 url_server_chat+'remove_user_feed.php',
 {feed_id : feed_id, id : id},
 function(){}
 );
 }

 /* Delete class background color li */
 if($('#VgChatListOnline .friend_'+id).hasClass('pnacf')){
 $('#VgChatListOnline .friend_'+id).removeClass('pnacf')
 }

 $('#bchatvg_'+id).remove();
 }
 var elmchat_ov = $('#vgchat_ovlay_ct');
 if(elmchat_ov.html() != ''){
 elmchat_ov.html('')
 .hide();
 $('#vgchat_ovlay').hide();
 $('html').removeClass('vgchat_over');
 }

 var box_count_hide = $('.count_box_hide .counts');
 var box_name_hide = $('.count_box_hide');
 var _count_hide = parseInt(box_count_hide.text()) || 0;


 if($(obj).parent().hasClass('name')){
 box_count_hide.text( parseInt(_count_hide - 1) );
 if(_count_hide <= 1) $('.count_box_hide').addClass('hide');
 $(obj).parent().remove();
 }else{
 /* kiểm tra phần name hide xem có ai không (có thì thằng cuối cùng đc hiển thị) */
 if(box_name_hide.find('.name').length > 0){
 var _id_hide = box_name_hide.find('.name:last-child').data('id') || 0;
 box_name_hide.find('.name:last-child').remove();
 $('#boxchat_'+_id_hide).parent().addClass('ac');
 box_count_hide.text( parseInt(_count_hide - 1) );
 if(_count_hide <= 1) $('.count_box_hide').hide();
 }
 }

 /* remove cookie */
 var data = {};
 data.to_id = id;
 removeHistoryCookie(data);

 /* romove boxchat thì phải remove luôn trong array_feed_owner để biết thằng máy này đã ngừng chát vs user khách hàng */
 /*
 if(isset(typeof array_feed_owner)){
 var _index = jQuery.inArray( parseInt(id), array_feed_owner );
 if( _index != -1 ){
 array_feed_owner.splice( _index, 1 );
 }
 }
 */
 }
 return false;
}


/**
 function get polls after
*/
function vgc_get_polls_after(id){
 if(parseInt(id) <= 0) return;

 var data = {};
 data.est = id;
 data.hash = $('#boxchat_'+id+' .hash_vgchat').text();
 data.to_id = id;
 data.send_id = $('#boxchat_'+id+' .send_id_vgchat').text();

 $.post(
 url_server_chat + 'ajax_polls_after.php',
 data,
 function(res){
 if(res.status == 0){
 $('#vgc_polls_after_'+id +' .vgc_quest_error').html(res.error);
 if(res.close == 1){
 remove_box_chat(id, this);
 }
 }else{
 $('#vgc_polls_after_'+id).html(res.html);
 return false;
 }
 },
 'json'
 )
}
/**
 function set polls after
*/
function set_polls_after(obj){

 var id = obj.id || 0;
 var quest = obj.quest || 0;
 var new_id = id;
 var poa_ans = 0;
 if(parseInt(id) <= 0) return false;
 var total_check = 0;
 if(new_id > 0 && new_id == 1515941){
 new_id = $('#vgc_support_id_1515941').val() || 0;
 if(new_id <= 0) new_id = 1515941;
 }

 $('.poa_ans').each(function(){
 if($(this).is(':checked')){
 total_check++;
 poa_ans = $(this).val();
 }
 })

 if(total_check <= 0){
 $('#vgc_polls_after_box_'+id+' .vgc_p_a_error').html('Bạn vui lòng chọn 01 lựa chọn');
 return false;
 }else{

 /* set poll after */
 var data = {};
 data.est = new_id;
 data.hash = $('#boxchat_'+id+' .hash_vgchat').text();
 data.to_id = id;
 data.send_id = $('#boxchat_'+id+' .send_id_vgchat').text();
 data.poa_id = quest;
 data.poa_ans = poa_ans;

 $('#vgc_polls_after .vgc_p_a_loadding').removeClass('vgc_hide');
 $.post(
 url_server_chat + 'ajax_polls_after_save.php',
 data,
 function(res){
 if(res.status == 0){
 $('#vgc_polls_after_box_'+id+' .vgc_p_a_error').html(res.error);
 $('#vgc_polls_after .vgc_p_a_loadding').addClass('vgc_hide');
 }else{
 remove_box_chat(id, this);
 return false;
 }
 },
 'json'
 )

 }
}

/**
 Hàm send msg lên server
*/

function send_chat_js(event, send, id){
 var code = (event.keyCode)? event.keyCode : event.which;
 if(code == 13 || send == 'submit'){
 var objtext = $('#boxchat_'+id+' .txt_'+id);
 if($('#box_send_'+id).length) objtext = $('#box_send_'+id);
 var vgclisttags = objtext.parent().find('.vgc_list_tags li');
 if(vgclisttags.length){
 vgclisttags.each(function(idx, el){
 if($(el).hasClass('vgc_sl_active')){
 $(this).click();
 }
 });
 }

 if(objtext.val().trim() != ''){
 var vgc_rand = Math.floor((Math.random() * 1000000) + 1);
 var data = {};
 var _date = new Date();
 var vgc_time = _date.getTime();
 data.message = objtext.val();
 data.to_id = $('#boxchat_'+id+' .to_id_vgchat').text() || $('#vgc_sp_to_id').val();
 data.name = $('#boxchat_'+id+' .name_vgchat').text() || $('#vgc_sp_to_name').val();
 data.send_id = $('#boxchat_'+id+' .send_id_vgchat').text() || $('#vgc_sp_send_id').val();
 data.pro_id = $('#boxchat_'+id+' .pro_id_vgchat').text();
 data.hash = $('#boxchat_'+id+' .hash_vgchat').text() || $('#vgc_sp_hash').val();
 data.time = $('#vgc_time_standby_'+id).val() || 0;
 data.vgc_time = vgc_time;
 if(data.time > 0) $('#vgc_time_standby_'+id).val(0);
 count_vgchat = parseInt($('#boxchat_'+id+' .count_vgchat').text()) || 0;
 if(count_vgchat <= 0) count_vgchat = parseInt($('#vgc_sp_count_vgchat').val() * 1) || 0;
 data.count_vgchat = count_vgchat;
 data.vgc_rand = vgc_rand;
 data.support_id = 0;
 data.partner_support_id = 0;
 //data.vgc_type = 'location';
 //data.vgc_location = {'lat': '21.0333', 'lon' : '105.85'};
 /*Nếu đang trong trang support và lần đầu tiên gửi tin nhắn thì check để xóa key trong mảng not answer*/
 if($('#vgc_helpsupport').length && count_vgchat == 1){
 /* kiểm tra có array vgc_array_not_answer không, nếu có thì xem có ký không để xóa */
 var current_not_answer = $.cookie('vgc_not_answer');
 if(isset(typeof current_not_answer) && current_not_answer != ''){
 var vgc_array_not_answer = current_not_answer.split('|').map(Number);
 var not_answer_index = jQuery.inArray( id, vgc_array_not_answer );
 if(jQuery.inArray(id, vgc_array_not_answer) != -1){
 vgc_array_not_answer.splice( not_answer_index, 1 );
 $.cookie('vgc_not_answer', vgc_array_not_answer.join("|"), {expires: 1, path : '/'})
 }
 }
 }
 var _link = document.location.href;
 if(_link.indexOf('quantrigianhang') == -1){
 data.link = _link;
 }else{
 data.link = '';
 }
 var _link_hidden = $('#vgc_pro_link_hidden_'+id).val() || '';
 if(_link_hidden != '') _link = _link_hidden;

 var to_name = $('#boxchat_'+id+' .to_name_vgchat').text();
 data.to_name = to_name;
 var boxchat_content = $('#boxchat_'+id+' .boxchat_'+ data.to_id +' .boxc_content');

 if(count_vgchat > 0){
 $('#boxchat_'+ id +' .count_vgchat').text('0');
 $('#vgc_sp_count_vgchat').val('0');
 }

 /* thêm biến hỏi xin vị trí của khách */
 var ask_location = parseInt($('#vgc_ask_location').val()) || 0;
 data.ask_location = ask_location;
 /* set vgc_ask_location ngay sau khi đã lấy đc */
 if(ask_location == 1) $('#vgc_ask_location').val('');

 /* Thêm support id */
 if( isset(typeof vgc_support_id) ){
 data.support_id = parseInt(vgc_support_id);
 }

 var support_name = $('#vgc_sp_support_name').val() || '';
 data.support_name = support_name;

 var support_image = $('#vgc_sp_support_image').val() || '';
 data.support_image = support_image;

 /*
 vgc_support_id là ở trang chat hỗ trợ vchat
 vgc_support_id_[boxchat_id] là boxchat nhỏ
 */
 var support_id = parseInt($('#vgc_support_id_'+id).val()) || 0;
 if(data.support_id <= 0) data.support_id = support_id;
 
 var partner_support_id = parseInt($('#vgc_partner_support_id').val()) || 0;
 data.partner_support_id = partner_support_id;
 /* kiểm tra dòng cuối cùng có phải là mình không nếu đúng là mình thì cho content vào đó */
 var dataappen = {};
 dataappen.box_id = data.to_id;
 dataappen.owner = 'rowme'; /* mình gửi đi nên class là rowme */
 dataappen.msg = safe_tags(data.message);
 dataappen.first = 1; /* check first = 1 chỉ có tác dụng với tin nhắn hình ảnh, ==1 để lần đầu tiên sẽ hiện hình loading, = 0 sẽ thay bằng ảnh */
 dataappen.vgc_time = vgc_time; /* thời gian hiện tại */
 dataappen.temmsg = 1; /* dùng để nhận biết là vừa gửi đi thì cho mờ tin nhắn */
 appendMsgToBoxchat(dataappen);

 /* vgc_rand để check chính tab này và đã appent message thì không appen lại lần nữa khi nhận onchat */
 if($('#vgc_random_'+id).length){
 $('#vgc_random_'+id).val(vgc_rand);
 }
 
 
 var data_vatgia = {
 user_id : data.send_id,
 estore_id : data.to_id,
 message: data.message 
 };

 setTimeout(function(){objtext.val('');},5);
 $.post(
 url_server_chat+'send.php',
 data,
 function(data){
 var msg = data.msg || '';
 var er = data.error || '';
 if(er == ''){
 
 /* gửi tin nhắn thành công thì gọi hàm đấu giá của vatgia*/
 if(typeof callbackVchatSend == 'function'){
 
 callbackVchatSend(data_vatgia);
 }
 
 /* nếu là tin nhắn hình ảnh thì file send sẽ trả về dữ liệu msg là 1 đường dẫn ảnh */
 if(msg != ''){
 $('#boxchat_'+id+' .rowme:last-child').remove();
 if($('#box_support .box_sp_history').length){
 $('#box_support .box_sp_history .rowme:last-child .box_message').removeClass('vgc_temmsg').html(msg);
 }else{
 dataappen.msg = msg;
 dataappen.return_msg = 1;
 dataappen.first = 0; /* check first = 1 chỉ có tác dụng với tin nhắn hình ảnh, ==1 để lần đầu tiên sẽ hiện hình loading, = 0 sẽ thay bằng ảnh */
 appendMsgToBoxchat(dataappen);
 }

 /* kiểm tra tin nhắn gửi có sản phẩm */
 if(data.buy != ''){
 if($('#boxchat_'+id+' .boxc_main .boxc_info').length){
 $('#boxchat_'+id+' .boxc_main .boxc_info').remove();
 }
 $('#boxchat_'+id+' .boxc_main div:eq(0)').after(data.buy);
 }
 }
 }
 else{
 $('#boxchat_'+id).find('.vgc_alert_error').html(er)
 .removeClass('vgc_hide');
 }

 /*objtext.val('');*/
 },
 "json"
 );
 }else{
 objtext.val('');
 setTimeout(function(){objtext.val('');},5);
 }
 }

}

function getTags(event, obj, id){
 /* kiểm tra text có dấu # không */
 var event = (event)? event : window.event;
 var code = event.keyCode;
 var regular = /(38|40|27)/;
 var start=/#/ig;
 var word=/#(\w+)/ig;
 var word_product = /@(\w+)/ig;
 var objs = $(obj);
 var content = objs.val();
 var go = content.match(start);
 var name = content.match(word);
 var name_pro = content.match(word_product);
 var tagscurrent = objs.parent().find('.vgc_list_tags');
 var data = {};

 var regular = /(38|40|27)/;
 if(code == 27) return;

 /* check sự kiện key down, key up */
 if(regular.test(code)){
 var items = objs.parent().find('.vgc_list_tags li');
 var itemsLen = items.length || 0;
 if (itemsLen <= 0) return
 var _index = 0;

 items.each(function(idx, el){
 if($(el).hasClass('vgc_sl_active')){
 _index = idx;
 }
 });
 items.eq(_index).removeClass('vgc_sl_active');

 if (code == 38){
 if(_index > 0){
 _index--; // up
 }else{
 _index = itemsLen - 1; // last
 }
 }
 if (code == 40){
 if(_index < itemsLen - 1){
 _index++; // down
 }else{
 _index = 0; // first
 }
 }

 items.eq(_index).addClass('vgc_sl_active');
 items.eq(_index).focus();

 /* auto scroll when key down, key up */
 var b1 = tagscurrent[0].getBoundingClientRect();
 var b2 = items.eq(_index)[0].getBoundingClientRect();
 if (b1.top>b2.top) {
 tagscurrent.scrollTop( tagscurrent.scrollTop()-b1.top+b2.top-10 );
 }
 else if (b1.bottom<b2.bottom) {
 tagscurrent.scrollTop( tagscurrent.scrollTop()-b1.bottom+b2.bottom+10);
 }
 }

 /* nếu có nhập vào ký tự sau dấu # */
 if(name != null){
 var strtags = name[0];
 if(strtags != '') strtags = strtags.replace('#', '');
 /* nếu < 5 ký tự và không phải là đang ấn vào dấu lên, xuống thì bắn đi lấy tags về */
 if(strtags.length < 5 && strtags.length > 0 && !regular.test(code)){
 /*nếu là trang help support thì lấy dữ liệu theo cách khách*/
 if($('#vgc_helpsupport').length){
 data.to_id = $('#vgc_sp_to_id').val() || 0;
 data.send_id = $('#vgc_sp_send_id').val() || 0;
 data.hash = $('#vgc_sp_hash').val() || '';
 }else{
 data.to_id = $('#boxchat_'+id+' .to_id_vgchat').text();
 data.send_id = $('#boxchat_'+id+' .send_id_vgchat').text();
 data.hash = $('#boxchat_'+id+' .hash_vgchat').text();
 }
 data.tags = strtags;

 $.post(
 url_server_chat + 'ajax_gettags.php',
 data,
 function(_result){
 if(_result.status == 1 && _result.html != ''){
 if( tagscurrent.length > 0 ){
 tagscurrent.remove();
 }
 objs.parent().append(_result.html);
 }else{
 if( tagscurrent.length > 0 ){
 tagscurrent.remove();
 }
 }
 },
 'json'
 );
 }
 }else{
 /* check tags @ sản phẩm */
 if(name_pro != null){
 /* 12/3/2015 Chien: tạm bỏ chức năng sugget sản phẩm vatgia */
 return;
 var strtags = name_pro[0];
 if(strtags != '') strtags = strtags.replace('@', '');
 /* nếu < 5 ký tự và không phải là đang ấn vào dấu lên, xuống thì bắn đi lấy tags về */
 if(strtags.length < 5 && strtags.length > 0 && !regular.test(code)){
 /*nếu là trang help support thì lấy dữ liệu theo cách khách*/
 if($('#vgc_helpsupport').length){
 data.to_id = $('#vgc_sp_to_id').val() || 0;
 data.send_id = $('#vgc_sp_send_id').val() || 0;
 data.hash = $('#vgc_sp_hash').val() || '';
 }else{
 data.to_id = $('#boxchat_'+id+' .to_id_vgchat').text();
 data.send_id = $('#boxchat_'+id+' .send_id_vgchat').text();
 data.hash = $('#boxchat_'+id+' .hash_vgchat').text();
 }
 data.tags = strtags;

 $.post(
 url_server_chat + 'ajax_gettags_product.php',
 data,
 function(_result){
 if(_result.status == 1 && _result.html != ''){
 if( tagscurrent.length > 0 ){
 tagscurrent.remove();
 }
 objs.parent().append(_result.html);
 }else{
 if( tagscurrent.length > 0 ){
 tagscurrent.remove();
 }
 }
 },
 'json'
 );
 }
 }else{
 if( tagscurrent.length > 0 ){
 tagscurrent.remove();
 }
 }
 }


}

/* select tags and add tags to input */
function vgc_select_tags(obj){
 var _texttags = $(obj).find('.vgc_text_tags').text();
 /* nếu trang help support thì gắn vào ô khách */
 if($('#vgc_helpsupport').length){
 $('#vgc_helpsupport .sp_send_text').val(_texttags)
 .focus();
 }else{
 $(obj).parents('.boxc_fromchat').find('textarea').val(_texttags)
 .focus();
 }
 var objtext = $(obj).parents('.boxc_fromchat').find('textarea');
 $(obj).parent().remove();
 autoGrow(objtext);
}

/* select emoji */
function vgc_select_emoji(obj){
 var _id = $(obj).data('id') || 0;
 var _key = $(obj).data('key') || '';
 
 
 if(_id > 0 && _key != ''){
 if($('#vgc_helpsupport').length){
 $('#vgc_helpsupport .sp_send_text').val(_key)
 .focus();
 send_chat_js('', 'submit', _id);  
 }else{
 $(obj).parents('.boxc_fromchat').find('textarea').val(_key)
 .focus();
 }
 }
}

/* keypress select tags */


var vgc_msglastoffline_remove = [];
function noticeLastMessage(data_msg, to_id){

 var elm = $('#standby_user_'+to_id);
 if(isset(typeof elm)){

 /* Hien tooltip */
 elm.find('.vgc_msglastoffline').show();
 elm.find('.vgc_arrowleft').show();

 /* Them message */
 var $font = $('<font>').append(data_msg);
 elm.find('.vgc_msglastoffline').html($font);
 vgc_msglastoffline_remove[$font.index()] = setTimeout(function() {

 /* An tooltip */
 elm.find('.vgc_msglastoffline').hide();
 elm.find('.vgc_arrowleft').hide();
 }, 5000);

 } /* End if(isset(typeof elm)) */

 /* Tooltip hover */
 $('.vgc_item_user')
 .mouseover(function() {
 $(this).find('.vgc_msglastoffline').show();
 $(this).find('.vgc_arrowleft').show();
 })
 .mouseout(function() {
 $(this).find('.vgc_msglastoffline').hide();
 $(this).find('.vgc_arrowleft').hide();
 });

} /* End function noticeLastMessage(data_msg, to_id) */


/*
 function notifi chat
*/
function notifychat(obj){
 var name = obj.name || '';
 var id = obj.id || 0;
 var t = '';
 if(name != ''){
 t = name+' yêu cầu bạn hỗ trợ ngay bây giờ';
 }else{
 t = 'Bạn nhận được yêu cầu bạn hỗ trợ ngay bây giờ';
 }
 
 if(id > 0){
 if(confirm(t)){
 getboxchat({id:id});
 }else{
 var rep_when_cancel = 0;
 if(isset(typeof _vcclient_config)){
 if(isset(typeof _vcclient_config.orther)){
 if(isset(typeof _vcclient_config.orther.rep_when_cancel)){
 rep_when_cancel = _vcclient_config.orther.rep_when_cancel.vl;
 }
 }
 }
 if(rep_when_cancel == 1){
 $.post(
 '/ajax_v1/ajax_reply_cancel_require_chat.php',
 {to_id : id, send_id : vgc_ad_id, text : rep_when_cancel_text},
 function(res){
 
 },
 'json'
 );
 }
 }
 }
}

function fn_raw_chat(data){
 if(isset(typeof vgc_read_log)){
 if(vgc_read_log == 1) console.log(data);
 }
 console.log(data);
 
 /* có 2 trường hợp
 1: ở trang vchat support thì hiện box khác
 2: ở vchat, vatgia thì tự create boxchat (riêng trang lịch sử chat thì không tự hiện boxchat)
 */

 /* kiểm tra xem nếu có support Id thì gắn đè vào biến support id trong form */
 var support_id = parseInt(data.support_id) || 0;
 if($('#vgc_support_id_'+data.send_id).length){
 if( $('#vgc_support_id_'+data.send_id).val() <= 0 ){
 $('#vgc_support_id_'+data.send_id).val(support_id);
 }
 }

 /* biến vgc_select_office của bên webclient bắn lên */
 var vgc_select_office = data.vgc_select_office || 0;

 var time = data.time || 0;
 var _date = new Date();
 var vgc_time = data.vgc_time || _date.getTime();
 var to_id = parseInt(data.send_id) || 0;
 var check_is_vchat = parseInt($('#vgc_check_feed_online').val()) || 0;
 var type_supplier = $('#type_supplier').length || 0;
 var panel_id = parseInt($('#vgc_send_id_pn').val()) || 0;
 var msg = data.msg || '';
 var vgc_rand = data.vgc_rand || 0;
 var system_action = data.system_action || 0;
 var action_event = data.action_event || '';

 
 /* chat trên trang vchat
 - kiểm tra nếu trang chat không đc bật
 - kiểm tra nếu là tin nhắn của mình
 - +1 vào thông báo ngay trên menu "Chat"
 - save cookie con số chat
 - Click vào menu chat thì xoá cookie đi
 */
 if(check_is_vchat){
 /* nếu trang chat không được bật */
 if($('#vgc_helpsupport').length <= 0){
 
 /*check chat của mình hoặc của ng khác*/
 if(data.send_id != panel_id){
 /* onchat của người khác */
 var boxchat_id = parseInt(data.send_id) || 0;
 if(boxchat_id <= 0) return false;
 
 /* nếu boxchat client gửi đến biến vgc_select_office,
 thì kiểm tra xem id của mình có nằm trong vgc_select_office không,
 nêu nằm trong đó thì ok, không thì return false luôn
 */
 if(vgc_select_office != '' && vgc_select_office != 0){
 if(vgc_support_id > 0){
 
 /* kiểm tra trong list office xem id của tài khoản hiện tài có nằm trong này không, nếu không thì return luôn */
 var list_select_office = vgc_select_office.split(',').map(Number);
 if(jQuery.inArray(vgc_support_id, list_select_office) == -1) return false;
 
 }
 }
 
 /*Nếu to_id != panel_id => return false*/
 if(typeof data.id == 'string'){
 var arrayToId = data.id.split(',').map(Number);
 if(jQuery.inArray(panel_id, arrayToId) == -1) return false;
 }else{
 if(data.id != panel_id) return false;
 }
 
 /*
 chat của support khác chat đến hoặc chat của mình chat
 - nếu có support_id và support_id > 0 thì kiểm tra xem có phải mình có quyền không, nếu không có quyền thì tắt luôn
 */
 if(isset(typeof vgc_support_id)){
 if(checkInArray(vgc_list_support, support_id) && support_id != vgc_support_id && support_id > 0){
 /*$('#box_send_'+data.id).attr({'disabled':'disabled', 'readonly':'readonly', 'disabled':true})
 prop("disabled", true);*/
 if($('#box_support_'+ boxchat_id).length){
 $('.boxtop_close').trigger('click');
 return;
 }else{
 return;
 }
 }
 }
 
 /*Nếu to_id != panel_id => return false*/
 if(typeof data.id == 'string'){
 var arrayToId = data.id.split(',').map(Number);
 if(jQuery.inArray(panel_id, arrayToId) == -1) return false;
 }else{
 if(data.id != panel_id) return false;
 }
 
 /* hết các trường hợp bỏ qua thì hiển thị notifi ở menu "Chat" */
 var _current_count_chat = parseInt(vgc_getCookie('ccc_vchat')) || 0;
 vgc_setCookie({name : 'ccc_vchat', value : (_current_count_chat + 1), expires : 1});
 
 if($('#menu_ccc_vchat').length){
 $('#menu_ccc_vchat').text(_current_count_chat + 1)
 .removeClass('vgc_hide');
 }
 }
 
 } 
 }
 
 
 
 /*------------------------Bắt đầu check onchat trên trang support--------------------------*/
 if(check_is_vchat && $('#vgc_helpsupport').length){


 /* Trường hợp 2 đang trong trang vchat và ở tab chuyên trang hỗ trợ khách hàng */
 /*
 - kiểm tra có phải onchat của chính mình không ( có thể là của mình, có thể là của hỗ trợ khác)
 = nếu của chính mình
 - xem boxchat mở chưa
 + mở rồi thì xem vgc_rand có = nhau không
 = bằng nhau thì thôi
 = không bằng nhau thì append vào
 + chưa mở thì thôi
 = nếu của ng khác ( có thể chat cho mình hoặc có thể chat cho hỗ trợ khác)
 + mở rồi
 = append vào luôn khong kiểm tra nữa
 - nếu support id không bằng id của chính mình thì khóa box trả lời lại
 + chưa mở
 - xem có trong list chờ không, list history không
 + xem support id có bằng id của chính mình không
 = có thì cộng thêm count
 = không thì thêm vào list chờ
 + không bằng id của chính mình thì xóa trong list chờ
 var boxchat_vgc_rand = parseInt($('#vgc_random_'+ data.id).val() || 0);
 */

 /* Onchat chính mình */
 
 if(data.send_id == panel_id){
 
 var boxchat_id = data.id || 0;
 if(boxchat_id <= 0) return false;

 /*
 chat của support khác chat đến hoặc chat của mình chat
 - nếu có support_id và support_id > 0 thì kiểm tra xem có phải mình có quyền không, nếu không có quyền thì tắt luôn
 */
 
 if(isset(typeof vgc_support_id)){
 if(support_id != vgc_support_id && support_id > 0){
 /*$('#box_send_'+data.id).attr({'disabled':'disabled', 'readonly':'readonly', 'disabled':true})
 prop("disabled", true);*/
 if($('#box_support_'+ boxchat_id).length){
 $('.boxtop_close').trigger('click');
 
 if($('#req_'+boxchat_id).length){
 $('#req_'+boxchat_id).remove();
 }
 reset_title();
 return;
 }else{
 /* nếu trong phần lịch sử chat mà có người này thì xóa luôn */
 if($('#req_'+boxchat_id).length){
 $('#req_'+boxchat_id).remove();
 reset_title();

 /* kiểm tra id của khách này có trong danh sách chưa trả lời không, có thì xóa đi */
 var current_not_answer = $.cookie('vgc_not_answer');
 if(isset(typeof current_not_answer) && current_not_answer != '' && current_not_answer !== null){
 var vgc_array_not_answer = current_not_answer.split('|').map(Number);
 var not_answer_index = jQuery.inArray( boxchat_id, vgc_array_not_answer );
 if(jQuery.inArray(boxchat_id, vgc_array_not_answer) != -1){
 vgc_array_not_answer.splice( not_answer_index, 1 );
 $.cookie('vgc_not_answer', vgc_array_not_answer.join("|"), {expires: 1, path : '/'})
 }
 }
 }
 return;
 }
 }
 }

 /*
 On chat của mình thì phải xử lý việc loại bỏ id trong mảng not_answer ra để không bị nhiều
 */
 
 var current_not_answer = VatGiaChatReadCookie("vgc_not_answer");
 if(isset(typeof current_not_answer) && current_not_answer != '' && current_not_answer !== null){
 var vgc_array_not_answer = current_not_answer.split('|').map(Number);
 var not_answer_index = jQuery.inArray( boxchat_id, vgc_array_not_answer );
 if(not_answer_index != -1){
 vgc_array_not_answer.splice( not_answer_index, 1 );
 VatGiaChatCreateCookie("vgc_not_answer",vgc_array_not_answer.join('|'), 1);
 }
 }


 if( $('#box_support_'+boxchat_id).length ){
 /* đã mở box */
 
 var boxchat_rand = parseInt($('#vgc_random_'+boxchat_id).val() || 0);

 /* nếu support id != id của mình thì disable lại box chat */
 if(isset(typeof vgc_support_id) && vgc_support_id > 0){
 if(checkInArray(vgc_list_support, support_id) && checkInArray(vgc_list_support, support_id) && support_id > 0){
 if(support_id != vgc_support_id){
 $('#box_send_'+data.id).attr({'readonly':'true', 'disabled':'disabled'});
 }
 }
 }

 /* Kiểm tra dòng chat vs time đã gửi lên có chưa, có rồi thì return luôn vì chính là tap mình đang chat */
 
 if(vgc_time > 0 && $('#vgc_me_send_'+boxchat_id+'_'+vgc_time).length){
 $('#vgc_me_send_'+boxchat_id+'_'+vgc_time).removeClass('vgc_temmsg');
 return false;
 }
 

 /* append msg to boxchat */
 var dataappen = {};
 dataappen.box_id = boxchat_id;
 dataappen.owner = 'rowme';
 dataappen.msg = msg;
 dataappen.vgc_rand = vgc_rand;
 dataappen.time = time;
 dataappen.vgc_time = vgc_time;
 dataappen.system_action = system_action;
 appendMsgToBoxchat(dataappen);
 } /* end check onchat của chính mình */
 else{
 /* của mình nhưng do support khác chat đến,
 - nếu đang trong list chờ thì xóa luôn
 */
 
 if(support_id != vgc_support_id && checkInArray(vgc_list_support, support_id)){
 if($('#newchat_support #req_'+data.id).length){
 $('#newchat_support #req_'+data.id).remove();
 }
 }
 /*
 Nếu đang mở box rồi thì disable box đi
 */
 $('#box_send_'+boxchat_id).attr({'disabled':'disabled', 'readonly':true});
 }
 }
 else{
 
 /* onchat của người khác */
 var boxchat_id = parseInt(data.send_id) || 0; 
 if(boxchat_id <= 0) return false;
 
 /* nếu boxchat client gửi đến biến vgc_select_office,
 thì kiểm tra xem id của mình có nằm trong vgc_select_office không,
 nêu nằm trong đó thì ok, không thì return false luôn
 */
 
 
 if(vgc_select_office != '' && vgc_select_office != 0){
 
 if(vgc_support_id > 0){
 
 /* kiểm tra trong list office xem id của tài khoản hiện tài có nằm trong này không, nếu không thì return luôn */
 var list_select_office = vgc_select_office.split(',').map(Number);
 
 if(jQuery.inArray(vgc_support_id, list_select_office) == -1) return false;
 
 /* nếu client truyền support_id lên tức là đã có người hỗ trợ trước rồi, phải xem support_id có
 thuộc nhóm list office không nếu không thì set cho = 0 để mọi người trong nhóm có thể trả lời được
 */
 if(support_id > 0){
 if(jQuery.inArray(support_id, list_select_office) == -1) support_id = 0;
 }
 }
 }

 /*
 chat của support khác chat đến hoặc chat của mình chat
 - nếu có support_id và support_id > 0 thì kiểm tra xem có phải mình có quyền không, nếu không có quyền thì tắt luôn
 */
 
 
 if(isset(typeof vgc_support_id)){
 if(checkInArray(vgc_list_support, support_id) && support_id != vgc_support_id && support_id > 0){
 /*$('#box_send_'+data.id).attr({'disabled':'disabled', 'readonly':'readonly', 'disabled':true})
 prop("disabled", true);*/
 
 if($('#box_support_'+ boxchat_id).length){
 $('.boxtop_close').trigger('click');
 return;
 }else{
 return;
 }

 /* nếu trong phần lịch sử chat mà có người này thì xóa luôn */
 if($('#req_'+boxchat_id).length){
 $('#req_'+boxchat_id).remove();
 }
 }
 }
 
 /*Nếu phần tab_history đang bị display none thì có thông báo để biết có khách đang chát đến*/
 var tab_history = $('#history_chat');
 if(tab_history.css('display') != 'block' || tab_history.length == 0){
 var _count = parseInt($('#tab_hischat_count').text()) || 0;
 $('#tab_hischat_count').text(_count + 1)
 .removeClass('vgc_hide');
 }
 
 /* action_evnet
 = poll: khách hàng đánh giá
 */
 
 if(action_event == 'poll'){
 /* nếu box đang mở thì append vào không thì thôi */
 if($('#box_support_'+to_id).length){
 /* append msg to boxchat */
 var html_poll = data.html_poll || '';
 if(html_poll != ''){
 $('#box_support_'+to_id).append(html_poll); 
 scrollTopBox({to_id:to_id}); 
 }
 }else{
 var elm_item = $('#req_'+to_id);
 /* chưa mở và có trong danh sách chờ và list history */
 if(elm_item.length){
 var t_count = parseInt(elm_item.find('.sp_count').text() * 1) || 0;
 t_count += 1;
 elm_item.find('.sp_count').text(t_count);
 elm_item.find('.msg').text(data.text);
 }
 }
 return false;
 }
 

 /* Chuyển chat từ người khác đến */
 var tranfer = data.tranfer || 0;
 if(tranfer == 1 && support_id == vgc_support_id){
 alert('Bạn nhận được quyền hỗ trợ [khách '+data.send_id+'] từ người khác');
 notifychat({name : 'Khách '+data.send_id, id : data.send_id});
 }
 
 
 
 /* thông báo trên ie nếu có chat mới */
 
 if(typeof notifi_ie == 'function'){
 notifi_ie();
 }
 
 
 /* Nhận được yêu cầu cần phải chat ngay từ khách hàng */
 var require_chat = data.require_chat || 0;
 if(require_chat == 1){
 notifychat({name : 'Khách '+data.send_id, id:data.send_id});
 }

 /*Nếu to_id != panel_id => return false*/
 if(typeof data.id == 'string'){
 var arrayToId = data.id.split(',').map(Number);
 if(jQuery.inArray(panel_id, arrayToId) == -1) return false;
 }else{
 if(data.id != panel_id) return false;
 }
 data.id = panel_id;

 /* chủ website chủ động tắt boxchat với khách hàng */
 if(isset(typeof data.close_chat) && data.close_chat == 1){
 var html_close = '<div style="overflow:hidden;font-size:12px;color:#999;padding:5px 40px 0 5px;text-align:right;line-height:25px;margin-bottom: 20px;">Khách hàng đã dừng cuộc chat<p style="margin: 0;"><span style="text-decoration: underline;cursor:pointer;color:#222;" onclick="vgc_rechat();">Đóng cửa số chat</span></p></div>';
 $('.box_sp_history').append(html_close);
 scrollTopBox({to_id:boxchat_id});
 return false;
 }
 
 


 if( $('#box_support_'+boxchat_id).length ){
 /* mở rồi */
 
 /* bỏ trạng thái đang nhắn tin */
 $('#typing').addClass('hide');
 
 /* nếu support id != id của mình thì disable lại box chat */
 if(isset(typeof vgc_support_id) && vgc_support_id > 0){
 if(checkInArray(vgc_list_support, support_id) && support_id > 0){
 if(support_id != vgc_support_id){
 $('#box_send_'+data.send_id).attr({'readonly':'true', 'disabled':'disabled'});
 }
 }
 }

 /* append msg to boxchat */
 var dataappen = {};
 dataappen.box_id = boxchat_id;
 dataappen.owner = 'rowfriend';
 dataappen.msg = msg;
 dataappen.vgc_rand = vgc_rand;
 dataappen.time = time;
 dataappen.vgc_time = vgc_time;
 dataappen.system_action = system_action;
 dataappen.ask_location = data.ask_location || 0;
 appendMsgToBoxchat(dataappen);

 /* thông báo notifi nếu đang không ở tab */
 console.log('Notifi: when opened boxchat and tab not active');
 vgc_notification_sound(data);

 }
 else{
 /* chưa mở */
 
 /* chặn chat nhận được thông báo thì bỏ thoát ra luôn */
 var banned = data.banned || 0;
 if(banned == 1){
 return false;
 }
 
 /* xoá trạng thái ở list chat nếu có */
 if($('#req_'+boxchat_id).length){
 $('#req_'+boxchat_id).find('.item_typing').addClass('hide');
 }
 
 /*
 Cho vào array mảng id khách chat đến và chưa trả lời
 không cần biết là của mình hay của ng khác, box đã mở hay chưa
 */
 var current_not_answer = VatGiaChatReadCookie("vgc_not_answer");
 if(current_not_answer == null || current_not_answer == ''){
 current_not_answer = boxchat_id;
 VatGiaChatCreateCookie("vgc_not_answer", parseInt(current_not_answer), 1);
 }else{
 var vgc_array_not_answer = current_not_answer.split('|').map(Number);
 if(jQuery.inArray(boxchat_id, vgc_array_not_answer) == -1){
 vgc_array_not_answer.push(boxchat_id);
 VatGiaChatCreateCookie("vgc_not_answer",vgc_array_not_answer.join('|'), 1);
 }
 }

 /* Kiểm tra có phải support_id == 0 hoặc của mình không
 - nếu không phải thì thôi bỏ qua
 - nếu phải thì tiếp tục làm
 */
 if(isset(typeof vgc_support_id)){
 if(support_id == 0 || support_id == vgc_support_id || (support_id > 0 && !checkInArray(vgc_list_support, support_id))){

 /* thông báo notifi nếu đang không ở tab */
 console.log('Notifi: when not open boxchat and tab not active');
 vgc_notification_sound(data);

 var elm_item = $('#req_'+boxchat_id);
 /* Kiểm tra xem có trong list khách hàng đang chat không
 - Nếu không có trong list đang chat thì thêm vào list đang chat, xóa ở list lịch sử chat
 - Nếu có ở list đang chat thì tăng count tin nhắn lên thôi
 */
 
 
 if(elm_item.length){
 
 if($('#req_'+boxchat_id).parents('.item').attr('id') != 'newchat_support'){
 
 /*xóa element hiện tại*/
 $('#req_'+boxchat_id).remove();
 
 /*Thêm element mới trong phần khách đang chat*/
 var customer_old = '';
 if(support_id > 0) customer_old = 'sp_old';
 var new_chat_html = '<div data-sname="" data-sid="'+ data.id +'" data-tname="'+ data.name +'" class="sp_row" data-sso="'+ data.send_id +'" id="req_'+ data.send_id +'">';
 new_chat_html += '<span class="sp_icon_online sonline"></span>';
 new_chat_html += '<span class="sp_count '+ customer_old +'">1</span>';
 new_chat_html += '<span class="close_chatting" title="Đóng cuộc chat này để nhận cuộc chat khác" onclick="close_chatting(this,{id:'+data.send_id+'})">&#10005;</span>';
 new_chat_html += '<input type="hidden" value="'+ data.time +'" id="vgc_box_sp_time_'+data.id+'" />';
 new_chat_html += '<p class="sinfo" onclick="getboxchat({id:'+ data.send_id +'});">';
 new_chat_html += '<span class="sname">'+ data.name +'</span>';
 new_chat_html += '<span class="msg">'+ data.msg +'</span>';
 new_chat_html += '</p>';
 new_chat_html += '<img class="item_typing hide" src="/themes/v1/images/loading22.gif" />';
 new_chat_html += '</div>';
 $('#newchat_support .spl_req').prepend(new_chat_html);
 
 }else{
 /*Cộng số count tin nhắn lên*/
 var t_count = parseInt(elm_item.find('.sp_count').text() * 1) || 0;
 t_count += 1;
 elm_item.find('.sp_count').text(t_count);
 elm_item.find('.msg').text(data.text);
 
 var content = elm_item[0].outerHTML;
 var parent_content = elm_item.parent('.spl_req');
 elm_item.remove();
 parent_content.prepend(content);
 }
 
 }else{
 var customer_old = '';
 if(support_id > 0) customer_old = 'sp_old';
 var new_chat_html = '<div data-sname="" data-sid="'+ data.id +'" data-tname="'+ data.name +'" class="sp_row" data-sso="'+ data.send_id +'" id="req_'+ data.send_id +'">';
 new_chat_html += '<span class="sp_icon_online sonline"></span>';
 new_chat_html += '<span class="sp_count '+ customer_old +'">1</span>';
 new_chat_html += '<span class="close_chatting" title="Đóng cuộc chat này để nhận cuộc chat khác" onclick="close_chatting(this,{id:'+data.send_id+'})">&#10005;</span>';
 new_chat_html += '<input type="hidden" value="'+ data.time +'" id="vgc_box_sp_time_'+data.id+'" />';
 new_chat_html += '<p class="sinfo" onclick="getboxchat({id:'+ data.send_id +'});">';
 new_chat_html += '<span class="sname">'+ data.name +'</span>';
 new_chat_html += '<span class="msg">'+ data.msg +'</span>';
 new_chat_html += '</p>';
 new_chat_html += '<img class="item_typing hide" src="/themes/v1/images/loading22.gif" />';
 new_chat_html += '</div>';
 $('#newchat_support .spl_req').prepend(new_chat_html);
 
 }
 
 
 /* chưa mở và có trong danh sách chờ và list history */
 /*
 if(elm_item.length){
 var t_count = parseInt(elm_item.find('.sp_count').text() * 1) || 0;
 t_count += 1;
 elm_item.find('.sp_count').text(t_count);
 elm_item.find('.msg').text(data.text);

 var content = elm_item[0].outerHTML;
 var parent_content = elm_item.parent('.spl_req');
 elm_item.remove();
 parent_content.prepend(content);

 }
 /* chưa mở và không có trong danh sách chờ và list history */
 /*
 else{
 var customer_old = '';
 if(support_id > 0) customer_old = 'sp_old';
 var new_chat_html = '<div data-sname="" data-sid="'+ data.id +'" data-tname="'+ data.name +'" class="sp_row" data-sso="'+ data.send_id +'" id="req_'+ data.send_id +'">';
 new_chat_html += '<span class="sp_icon_online sonline"></span>';
 new_chat_html += '<span class="sp_count '+ customer_old +'">1</span>';
 new_chat_html += '<span class="close_chatting" title="Đóng cuộc chat này để nhận cuộc chat khác" onclick="close_chatting(this,{id:'+data.send_id+'})">&#10005;</span>';
 new_chat_html += '<input type="hidden" value="'+ data.time +'" id="vgc_box_sp_time_'+data.id+'" />';
 new_chat_html += '<p class="sinfo" onclick="getboxchat({id:'+ data.send_id +'});">';
 new_chat_html += '<span class="sname">'+ data.name +'</span>';
 new_chat_html += '<span class="msg">'+ data.msg +'</span>';
 new_chat_html += '</p>';
 new_chat_html += '</div>';
 $('#newchat_support .spl_req').append(new_chat_html);
 }
 */
 }
 } /*End check if(isset(vgc_support_id))*/

 else{
 /* không có support id */
 if(support_id > 0 && support_id != vgc_support_id){
 if($('#newchat_support .spl_req #req_'+boxchat_id).length){
 $('#newchat_support .spl_req #req_'+boxchat_id).remove();
 }
 }
 }

 }

 }


 }/*------------------Kết thúc check onchat trên trang support------------------*/

 /*------------------Bắt dầu check onchat trên trang thường------------------*/
 else{
 /*
 Luồng boxchat nhỏ:
 - Nếu location.hostname = 'vchat' return;
 - Tạo âm thanh
 - Tạo dữ liệu để append
 - Kiểm tra tin nhắn nhận được là từ đâu
 + từ mình
 = kiểm tra boxchat có chưa
 . có rồi thì append dữ liệu vào
 . chưa có thì bật boxchat lên
 + từ người khác
 = kiểm tra boxchat có chưa
 . có rồi thì append dữ liệu vào
 . chưa có thì bật boxchat lên

 */

 /* Tạo dữ liệu để append */
 var msg = data.msg;
 var to_image = $('#boxchat_'+ data.send_id +' to_image_vgchat').text();
 var boxchat_content = $('#boxchat_'+ data.send_id +' .boxc_content');
 var pro_id = data.pro_id || 0;
 var nameChat = ''; /* Tên người chát */
 var vgc_send_id_pn = panel_id;

 /* Kiểm tra xem tin nhắn nhận được là từ đâu */
 if(vgc_send_id_pn == data.send_id){

 /* Nếu tin nhắn từ 1 support cùng nhóm mình chat đến
 - nếu boxchat đang bật thì xóa đi
 - chưa bật thì thôi luôn
 */
 if(isset(typeof vgc_support_id)){
 if(checkInArray(vgc_list_support, support_id) && support_id != vgc_support_id && support_id > 0){
 /*$('#box_send_'+data.id).attr({'disabled':'disabled', 'readonly':'readonly', 'disabled':true})
 prop("disabled", true);*/
 if($('#boxchat_'+ data.id).length){
 close_box_chat(data.id);
 reset_title();
 return;
 }else{
 return;
 }
 }
 }

 /* Tin nhắn từ mình chat đến hoặc từ support chat đến */
 if($('#boxchat_'+ data.id).length > 0){

 /* Đã bật boxchat rồi thì append tin nhắn vào không thì tạo boxchat */
 var dataappen = {};
 var _date = new Date();
 var vgc_time = data.vgc_time || _date.getTime();
 /* Kiểm tra dòng chat vs time đã gửi lên có chưa, có rồi thì return luôn vì chính là tap mình đang chat */
 if(vgc_time > 0 && $('#vgc_me_send_'+data.id+'_'+vgc_time).length){
 $('#vgc_me_send_'+data.id+'_'+vgc_time).removeClass('vgc_temmsg');
 return false;
 }

 /* append tin nhắn */
 dataappen.box_id = data.id;
 dataappen.owner = 'rowme';
 dataappen.msg = msg;
 dataappen.vgc_rand = vgc_rand;
 dataappen.time = time;
 dataappen.vgc_time = vgc_time;
 dataappen.system_action = system_action;
 appendMsgToBoxchat(dataappen);

 }else{

 /* nếu là trang lịch sử chat thì không bật boxchat lên */
 if($('#vgc_type_history_chat').length > 0) return;
 create_chat_box({id:data.id,send_id:vgc_send_id_pn,iPro:pro_id});
 }

 }else{

 /* Tin nhắn đến từ khách chat đến */

 /* nếu vừa nãy send_id đã không bằng panel_id rồi thì tức là của người khác chat đến,
 nếu mà của người khác chat đến thì to_id phải bằng panel_id
 nếu to_id != panel_id thì retun false luôn
 */
 if(vgc_send_id_pn != data.id) return false;

 /* Nếu tin nhắn từ 1 support cùng nhóm mình chat đến
 - nếu boxchat đang bật thì xóa đi
 - chưa bật thì thôi luôn
 */

 /* nếu boxchat client gửi đến biến vgc_select_office,
 thì kiểm tra xem id của mình có nằm trong vgc_select_office không,
 nêu nằm trong đó thì ok, không thì return false luôn
 */
 if(vgc_select_office != '' && vgc_select_office != 0){
 if(vgc_support_id > 0){

 /* kiểm tra trong list office xem id của tài khoản hiện tài có nằm trong này không, nếu không thì return luôn */
 var list_select_office = vgc_select_office.split(',').map(Number);
 if(jQuery.inArray(vgc_support_id, list_select_office) == -1) return false;

 /* nếu client truyền support_id lên tức là đã có người hỗ trợ trước rồi, phải xem support_id có
 thuộc nhóm list office không nếu không thì set cho = 0 để mọi người trong nhóm có thể trả lời được
 */
 if(support_id > 0){
 if(jQuery.inArray(support_id, list_select_office) == -1) support_id = 0;
 }
 }
 }

 if(isset(typeof vgc_support_id)){
 if(checkInArray(vgc_list_support, support_id) && support_id != vgc_support_id && support_id > 0){
 /*$('#box_send_'+data.id).attr({'disabled':'disabled', 'readonly':'readonly', 'disabled':true})
 prop("disabled", true);*/
 if($('#boxchat_'+ data.send_id).length){
 close_box_chat(data.send_id);
 reset_title();
 return;
 }else{
 return;
 }
 }
 }

 /* thông báo notifi nếu đang không ở tab */
 vgc_notification_sound(data);
 /*
 Cho vào array mảng id khách chat đến và chưa trả lời
 không cần biết là của mình hay của ng khác, box đã mở hay chưa
 */
 if(isset(typeof vgc_ad_id)){
 var current_not_answer = VatGiaChatReadCookie("vgc_not_answer");
 if(current_not_answer == null || current_not_answer == ''){
 current_not_answer = data.send_id;
 VatGiaChatCreateCookie("vgc_not_answer", parseInt(current_not_answer), 1);
 }else{
 var vgc_array_not_answer = current_not_answer.split('|').map(Number);
 if(jQuery.inArray(data.send_id, vgc_array_not_answer) == -1){
 vgc_array_not_answer.push(data.send_id);
 VatGiaChatCreateCookie("vgc_not_answer",vgc_array_not_answer.join('|'), 1);
 }
 }
 }

 /* Kiểm tra boxchat đã bật chưa, chưa thì bật lên, rồi thì append dữ liệu vào */
 if($('#boxchat_'+ data.send_id).length > 0){


 /* kiểm tra dòng cuối cùng có phải là mình không nếu đúng là mình thì cho content vào đó */
 var dataappen = {};
 var _date = new Date();
 dataappen.box_id = data.send_id;
 dataappen.owner = 'rowfriend';
 dataappen.msg = msg;
 dataappen.vgc_rand = vgc_rand;
 dataappen.time = time;
 dataappen.vgc_time = data.vgc_time || _date.getTime();
 dataappen.system_action = system_action;
 dataappen.ask_location = data.ask_location || 0;
 appendMsgToBoxchat(dataappen);
 }else{

 /* nếu là trang lịch sử chat thì không bật boxchat lên */
 if($('#vgc_type_history_chat').length > 0) return;
 create_chat_box({id:data.send_id,send_id:vgc_send_id_pn,iPro:pro_id});
 
 /* thông tin đấu giá của boxchat khi bật lên */
 var data_vatgia = {
 user_id : vgc_send_id_pn,
 estore_id : data.send_id
 };
 if(typeof callbackVchatOpen == 'function'){
 callbackVchatOpen(data_vatgia);
 }
 
 }
 }


 /* kiểm tra xem box có không và đang ẩn mà có tin nhắn thì báo lên cho biết */
 var boxvg = $('#bchatvg_'+data.send_id);
 if(boxvg.length){
 if(!boxvg.hasClass('ac')){
 /* thêm sự kiện nháy mầu vào chỗ name hide */
 if(!$('#showboxchat .count_box_hide').hasClass('vgc_activemsg')){
 $('#showboxchat .count_box_hide').addClass('vgc_activemsg');
 }

 /* hiển thị số tin nhắn offline và mầu sắc */
 var box_count_hide_mgsoff = 0; /* số tin nhắn off line của user này */
 box_count_hide_mgsoff = parseInt($('#nameh_'+data.send_id+' .vgc_count_msgoff').text()) || 0;
 box_count_hide_mgsoff += 1;
 $('#nameh_'+data.send_id+' .vgc_count_msgoff').text(box_count_hide_mgsoff)
 .show();
 if(!$('#nameh_'+data.send_id).hasClass('vgc_check_count_msgoff')){
 $('#nameh_'+data.send_id).addClass('vgc_check_count_msgoff')
 }


 }
 } /* end boxvg.lenght */

 }
 /*---------------Kết thúc check onchat trên trang thường-------------------*/
} /* end function */

/* event logout */
function fn_raw_logout(data){
 
 console.log(data);
 
 var _logout = data.log || 0;
 var _to_id = data.to_id || 0;
 if(_to_id > 0){
 if(isset(typeof vgc_support_id)){
 if(vgc_support_id == _to_id){
 window.location.reload();
 }
 }
 }
 if(_logout == 1){
 if(confirm("Tài khoản của bạn đã bị Thoát ở một trình duyệt khác. Vui lòng F5 lại trình duyệt để tiếp tục sử dụng")){
 window.location.reload();
 }else{
 window.location.reload();
 }

 }
}

/**
 Ham append message to content chat
*/
function appendMsgToBoxchat(data){
 var boxchat_id = data.box_id || 0;
 var owner_msg = data.owner || 'rowme';
 var time = data.time || 0;
 var msg = data.msg || '';
 var temmsg = data.temmsg || 0; /* phân biệt tin nhắn vừa gửi lên chờ socket trả về */
 var return_msg = data.return_msg || 0; /* tin nhắn tức socket trả về */
 msg = msg.replace(/&lt;br&gt;/g, ' <br> ');
 var ask_location = data.ask_location || 0;
 if(ask_location){
 msg = 'Chủ website gửi một yêu cầu xin vị trí hiện tại của bạn <br><br><button onclick="send_location()">Chia sẻ vị trí hiện tại</button>';
 }
 
 var avatarVg = '//static.vatgia.com/css/multi_css_v2/standard/no_avatar_xx_small.gif';
 if(temmsg == 1 || return_msg == 1){
 avatarVg = isset(typeof vgc_support_img)? vgc_support_img : ( data.image || '//static.vatgia.com/css/multi_css_v2/standard/no_avatar_xx_small.gif' );
 }
 
 var to_image = '<p class="box_name"><img class="icon_img" src="'+avatarVg+'" /></p>';
 var system_action = data.system_action || 0;
 var first_msg = data.first || 0; /*=1 là tin nhắn sau khi gửi append vào, =0 là tin nhắn socket trả về */

 
 var _date = new Date();
 var vgc_time = parseInt(data.vgc_time) || _date.getTime();
 var classTemmsg = '';
 if(temmsg == 1 && return_msg == 0) classTemmsg = ' vgc_temmsg';

 /*var vgc_rand = parseInt(data.vgc_rand) || 0;*/
 /*var vgc_rand_current = parseInt($('#vgc_random_'+boxchat_id).val()) || 0;*/
 /*var vgc_time = parseInt($('#vgc_time_'+boxchat_id).val()) || 0;*/
 /*
 kiểm tra mã rand hiện tại của box có == mã rand trả về từ sk không
 nếu = nhau thì không append vào nữa
 hoặc nếu = 0 thì cập nhật vào

 $('#boxchat_'+boxchat_id+ ' .boxc_content .row:last-child .msgchat').append('<font>'+msg+'</font><br>');
 */

 if(system_action > 0){

 $('#boxchat_'+boxchat_id+ ' .boxc_content').append(msg);
 scrollTopBox({to_id:boxchat_id});
 return false;

 }

 /* Kiểm tra dòng chat vs time đã gửi lên có chưa, có rồi thì return luôn vì chính là tap mình đang chat */
 if(vgc_time > 0 && $('#vgc_me_send_'+boxchat_id+'_'+vgc_time).length) return false;

 /*if(vgc_rand != vgc_rand_current || vgc_rand == 0 ){*/
 /* khi append msg vào thì cập nhật lại vgc_rand luôn */
 /*
 if($('#vgc_random_'+boxchat_id).length && return_msg == 0){
 $('#vgc_random_'+boxchat_id).val(vgc_rand);
 }
 */
 /*if(time > 0 && time == vgc_time) return;

 $('#vgc_time_'+boxchat_id).val(time);*/

 /* boxchat support */
 if($('#box_support_'+ boxchat_id).length){
 if( $('#box_support_'+ boxchat_id + ' .box_row:last-child').hasClass(owner_msg) ){
 to_image = '';
 }
 if(msg.indexOf('vchat.vn/pictures/service/') > 0 && first_msg == 1){
 msg = '<span class="send_file_loadding"></span>';
 }
 $('#box_support_'+ boxchat_id).append('<div class="'+ owner_msg +' box_row">'+ to_image +'<span id="vgc_me_send_'+boxchat_id+'_'+vgc_time+'" class="box_message '+classTemmsg+'">'+msg+'</span></div>');
 }
 /* boxchat cũ */
 else{
 if(msg.indexOf('vchat.vn/pictures/service/') > 0 && first_msg == 1){
 msg = '<span class="send_file_loadding"></span>';
 }
 if( $('#boxchat_'+boxchat_id+ ' .boxc_content .row:last-child').hasClass(owner_msg) ){
 $('#boxchat_'+boxchat_id+ ' .boxc_content').append('<div class="'+ owner_msg +' row"><span id="vgc_me_send_'+boxchat_id+'_'+vgc_time+'" class="msgchat '+classTemmsg+'"><font>'+msg+'</font><br><i class="ic_chat"></i></span></div>');
 }else{
 if(owner_msg == 'rowme') to_image = '';
 $('#boxchat_'+boxchat_id+ ' .boxc_content').append('<div class="'+ owner_msg +' row">'+ to_image +'<span id="vgc_me_send_'+boxchat_id+'_'+vgc_time+'" class="msgchat '+classTemmsg+'"><font>'+msg+'</font><br><i class="ic_chat"></i></span></div>');
 }
 }


 scrollTopBox({to_id:boxchat_id});


 /* nếu box đang bị ẩn thị cho mầu nhấp nháy để biết có người chát */
 vatgiatToggleBoxChat({to_id:boxchat_id,status:0});

 /*}*/

}


/*
 vatgiatToggleBoxChat
 Hàm hiển thị / ẩn boxchat xuống dạn thanh nhỏ 160px
 - Mỗi lần ẩn hiện thì phải set lại cookie cho status đang là ẩn hay hiện
*/
function vatgiatToggleBoxChat(obj){
 var box_id = obj.to_id || 0;
 var status = obj.status || 0; /* 0: add class, 1: removeclass */
 var objName = $('#boxchat_'+box_id);
 /*
 kiểm tra box đang show hay hide
 -box show thì thôi
 -box hide thì:
 + kiểm tra đã có class messaging chứa (có rồi thì thôi chỉ cộng thêm số count lên)
 + chưa có thì add class vào và cộng cố count lên và hiển thị count
 */
 var msgobj = $(objName.next('.box_onlyname').find('.count_msg'));
 if(objName.css('display') != 'block'){
 /* trường hợp vẫn đang ẩn boxchat (dạng thu nho 160px) */
 if(status == 0){
 var msg_count = parseInt(msgobj.text()) || 0; /* count tin nhắn hiện tại */

 /* nếu đã có class messaging rồi thì thôi chỉ cần cộng count_msg vào thôi */
 if(!objName.next('.box_onlyname').hasClass('messaging')){
 $(objName.next('.box_onlyname')).addClass('messaging');
 msgobj.removeClass('hide');
 }
 msgobj.text(msg_count+1);

 /*
 Set lại cookie cho boxchat
 -- nếu trong trang help support thì không set cookie
 */

 if($('#vgc_helpsupport').length <= 0){
 var data_history = {};
 data_history.status = 2; /*trạng thái ẩn*/
 data_history.to_id = box_id;
 data_history.pro_id = 0;
 data_history.count_msg = msg_count+1;
 addToHistory(data_history);
 }

 }else{
 /* click vào name (160px) để hiển thị lên thì xóa class messaging */
 $(objName.next('.box_onlyname')).removeClass('messaging');
 msgobj.text('0');
 msgobj.addClass('hide');
 }
 }

}

/**
 scrollTopBox
 scroll boxchat content luôn luôn về vị trí cuối cúng
*/
function scrollTopBox(obj){
 var to_id = obj.to_id || 0;
 var elm = $('#boxchat_'+to_id+ ' .boxc_content');
 if($('#box_support .box_sp_history').length) elm = $('#box_support .box_sp_history');

 if(elm.length > 0){
 var lastitem = elm.find('div:last').outerHeight();
 setTimeout(function(){
 elm[0].scrollTop = (elm[0].scrollHeight)+lastitem;
 }, 200);

 }
}

/**
 hide_panel_vgchat
 ẩn hiện panel chát bên phải khi click vào nút ẩn hiện
*/
function hide_panel_vgchat(){
 if($('#panel_chat_vatgia .box-user').css('display') == 'block'){
 $('#panel_chat_vatgia .box-user').hide();
 $('#panel_chat_vatgia #hide_panel_vgchat').removeClass('hide');
 }else{
 if($('#vgc_help_pn').length > 0){
 $('#vgc_help_pn').remove();
 }
 $('#panel_chat_vatgia .box-user').removeClass('hide')
 .show();
 $('#panel_chat_vatgia #hide_panel_vgchat').addClass('hide');
 if(isset(typeof ga)) ga('send', 'event', 'Open panel chat', 'Click', 'vatgia.com');
 /* Tạm thởi bỏ đi ngày 05/07/2014 vì không còn list gian hàng online ở panel nữa nên khong cần get ra */
 /* vgcGetInfoEstore(); */
 }
 if($('#vatgia_note_message').length) $('#vatgia_note_message').remove();
 /*change_panel_height(document.location.host);*/
}

/* 4s thì hiện icon help */
setTimeout(function(){
 if($('#vgc_help_pn').length > 0){
 $('#vgc_help_pn').removeClass('vgc_hide')
 .show();
 }
}, 3000);

function vgc_Closehelp(){
 $('#vgc_help_pn').remove();
}

/**
 RemoveHistoryCookie
 xóa cookie theo boxchat id khi người dùng tắt boxchat
*/
function removeHistoryCookie(obj){
 var to_id = parseInt(obj.to_id) || 0;
 if(to_id > 0){
 var current_history = VatGiaChatReadCookie("vgchat_history");
 var chec_u_id = ","+to_id+",";
 var arr = current_history.split('|').map(Number);
 var new_arr = new Array();
 for(var i = 0; i < arr.length; i++){
 var new_value = ','+arr[i];
 if(new_value.indexOf(chec_u_id) < 0 && arr[i].length > 0){
 new_arr.push(arr[i]);
 }
 }
 current_history = new_arr.join("|");
 VatGiaChatCreateCookie("vgchat_history",current_history,1);
 }
}


/* function search list user */
function searchListUser(obj){
 var hold_val = $(obj).val();
 if( hold_val != ''){
 //do something
 $(obj).parents(".box-user").find("ul li").each(function(){
 var search_name = $.trim($(this).find('span.name').text()).toLowerCase();
 var keyword = $.vn_str_filter(hold_val).toLowerCase();
 if($.vn_str_filter(search_name).match(keyword) != keyword){
 $(this).hide();
 }else{
 $(this).show();
 }
 });

 }else{
 $(obj).parents(".box-user").find("ul li").show();
 }
}
$.vn_str_filter = function (str){
 if(typeof(str)!="string") return;
 if(str==null) return;
 var mang = new Array();
 var strreplace = new Array("A","D","E","I","O","U","Y","a","d","e","i","o","u","y");

 mang[0]=new Array("Ã€","Ã","áº¢","Ãƒ","áº ","Ã‚","áº¤","áº¦","áº¨","áºª","áº¬","Ä‚","áº®","áº°","áº²","áº´","áº¶");
 mang[1]=new Array("Ä");
 mang[2]=new Array("Ãˆ","Ã‰","áºº","áº¼","áº¸","ÃŠ","á»€","áº¾","á»‚","á»„","á»†");
 mang[3]=new Array("ÃŒ","Ã","á»ˆ","Ä¨","á»Š");
 mang[4]=new Array("Ã’","Ã“","á»Ž","Ã•","á»Œ","Ã”","á»’","á»","á»”","á»–","á»˜","Æ ","á»œ","á»š","á»ž","á» ","á»¢");
 mang[5]=new Array("Ã™","Ãš","á»¦","Å¨","á»¤","Æ¯","á»ª","á»¨","á»¬","á»®","á»°");
 mang[6]=new Array("á»²","Ã","á»¶","á»¸","á»´");

 mang[7]=new Array("Ã ","Ã¡","áº£","Ã£","áº¡","Ã¢","áº¥","áº§","áº©","áº«","áº­","Äƒ","áº¯","áº±","áº·","áº³","áºµ");
 mang[8]=new Array("Ä‘");
 mang[9]=new Array("Ã¨","Ã©","áº»","áº½","áº¹","Ãª","á»","áº¿","á»ƒ","á»…","á»‡");
 mang[10]=new Array("Ã¬","Ã­","á»‰","Ä©","á»‹");
 mang[11]=new Array("Ã²","Ã³","á»","Ãµ","á»","Ã´","á»“","á»‘","á»•","á»—","á»™","Æ¡","á»","á»›","á»Ÿ","á»¡","á»£");
 mang[12]=new Array("Ã¹","Ãº","á»§","Å©","á»¥","Æ°","á»«","á»©","á»­","á»¯","á»±");
 mang[13]=new Array("á»³","Ã½","á»·","á»¹","á»µ");

 for (i=0;i<=mang.length-1;i++)
 for (i1=0;i1<=mang[i].length-1;i1++){
 var regex = new RegExp(mang[i][i1], 'g');
 str=str.replace(regex,strreplace[i]);
 }

 return str;
}

/*
 Add history: thêm các biến vào trong cookie
 box_id: default: 0 (id boxchat của người chát)
 pro_id: default: 0 (sản phẩm đang xem là gì)
 status: default: 1 (trạng thái ẩn hiện của của box 1: hiện, 0: ẩn )
 count_msg: default: 0 (if boxchat đang ẩn thì mới add count_msg, đây là só tin nhắn gửi lên người nhận nhưng chưa đọc)
*/
function addToHistory(obj){
 var to_id = obj.to_id || 0;
 var pro_id = obj.pro_id || 0;
 var box_status = obj.status || 1;
 var count_msg = obj.count_msg || 0;

 var box_data = to_id+','+pro_id+','+box_status+','+count_msg; /* Dữ liệu mặc định */
 var chec_u_id = ":"+to_id+","; /* Dữ liệu dùng để check trong cookie */

 if($('#boxchat_'+to_id).css('display') == 'block') count_msg = 0;/* nếu box đang được mở thì set count_msg = 0 */

 if(to_id <= 0) return ''; /* Nếu không có boxchat hợp lệ thì thoát khỏi hàm */

 var current_history = VatGiaChatReadCookie("vgchat_history"); /* Đọc cookie để lấy dữ liệu */

 /* Nếu chưa có cookie thì add luôn cookie với dữ liệu là box_data */
 if(current_history == null){
 current_history = box_data;
 VatGiaChatCreateCookie("vgchat_history",current_history,1);
 return false;

 }else{
 var check_found = false;
 var arr = current_history.split('|').map(Number); /* Ngắt cookie ra thành mảng vì có nhiều boxchat lưu cookie */
 for(var i = 0; i < arr.length; i++){
 var new_value = ':'+arr[i];

 /* Chỉ sửa cookie của boxchat đang được tác động */
 if(new_value.indexOf(chec_u_id) >= 0){
 var arr2 = arr[i].split(",").map(Number);
 var old_pro_id = arr2[1] || 0; /* sản phẩm cũ đang có */
 /* nếu pro_id mới truyển vào <=0 hoặc != với sản phẩm cũ thì thay thế data */
 if(pro_id <= 0 && old_pro_id > 0){
 box_data = to_id+','+old_pro_id+','+box_status+','+count_msg;
 }

 arr[i] = box_data; /* Gắn lại dữ liệu vào mảng cookie ban đầu */
 check_found = true;
 if(arr[i].length <= 0) delete arr[i];
 }
 } /* End for */

 /* max history chat la 3*/
 if(arr.length > 2){
 arr.shift();
 }
 current_history = arr.join("|");
 if(!check_found){
 current_history = box_data + "|" + current_history;
 }
 VatGiaChatCreateCookie("vgchat_history",current_history,1);

 }
}

/* Function switch resize screen boxchat */
function fullscreen( id ){
 var _w = $(window).width();
 var _l = (_w - 600)/2;
 var elmChat = $('#bchatvg_'+id);
 var elmChatOv = $('#vgchat_ovlay_ct');

 var Contentovl = elmChatOv.html();
 if(Contentovl == ''){
 $('#vgchat_ovlay').show();
 $('html').addClass('vgchat_over');
 elmChatOv.show()
 .css({'left':_l+'px'});
 elmChatOv.html('');
 elmChatOv.append(elmChat.html());
 elmChat.html('');
 if(elmChatOv.find('.boxc_info').length <= 0){
 elmChatOv.find('.boxc_content').css({'height':'350px', 'max-height' : '350px'});
 }else{
 elmChatOv.find('.boxc_content').css({'height':'360px', 'max-height' : '360px'});
 }

 }else{
 $('#vgchat_ovlay').hide();
 $('html').removeClass('vgchat_over');
 elmChatOv.hide();
 elmChat.html('');
 elmChat.append(elmChatOv.html());
 elmChatOv.html('');

 if(!elmChat.hasClass('ac')){
 elmChat.addClass('ac');
 }

 elmChat.find('.boxc_content').css({'max-height': '210px', 'height': '210px'});
 }
 scrollTopBox({to_id: id});
}

/* Function search content (msg) chat of user */
function boxchat_smsg( event, obj, id ){
 var txtmsg = $(obj);
 var data = {};
 data.keyword = txtmsg.val();
 data.to_id = $('#boxchat_'+id+' .to_id_vgchat').text();
 data.send_id = $('#boxchat_'+id+' .send_id_vgchat').text();
 data.hash = $('#boxchat_'+id+' .hash_vgchat').text();
 var boxchat_content = $('#boxchat_'+id+' .boxc_content');

 if(event.keyCode==13){
 $.post(
 url_server_chat + 'smsg.php',
 data,
 function(data){
 if(data.error == '' && data.msg != ''){
 boxchat_content.html('');
 boxchat_content.append(data.msg);
 }
 },
 'json'
 );
 }
}

function boxchat_smsg_click(event){
 event.stopPropagation();
}

/*Function change city in send multy estore*/
function change_city_estore(obj){
 var id = parseInt($(obj).val()) || 0;
 var data = {};
 data.cou_id = id;
 data.list_estore = $('#ivtestore_to_id').val() || '';
 data.send_id = $('#ivtestore_send_id').val() || 0;
 data.pro_id = $('#ivtestore_pro_id').val() || 0;
 var elm_listgh = $('#ivtEstore .ivtallinfo p');
 var elm_error = $('#ivtestoreError');
 var elm_btn = $('#ivtEstore .ivtbtn');
 var elm_hash = $('#ivtestore_hash');

 if(id > 0 && data.list_estore != ''){
 $.post(
 url_server_chat + "ivtestore_ajax_city.php",
 data,
 function(d){
 if(d.error == ''){
 elm_listgh.html(d.html);
 elm_btn.show();
 elm_error.text('');
 elm_hash.val(d.hash);
 $('#ivtestore_after_to_id').val(d.list_to_id);
 }else{
 elm_error.text(d.error).show();
 elm_listgh.html(d.error);
 elm_btn.hide();
 $('#ivtestore_after_to_id').val('');
 }
 $('#ivtestoreload').hide();
 },
 'json'
 );
 }
}

/* Function show popup invent estore */
function boxchat_invent_estore(obj){
 var send_id = obj.send_id || 0;
 var pro_id = obj.pro_id || 0;
 obj.to_id = (vgc_list_estore_online)? vgc_list_estore_online : '';
 var ivtdefault = VatGiaChatReadCookie("ivtestore");
 obj.ivtdefault = ivtdefault;

 var element_ivtestore = document.createElement('div');
 var body_vgchat = document.getElementsByTagName('body')[0];
 element_ivtestore.id = 'boxchat_ivtestore';
 body_vgchat.appendChild(element_ivtestore);
 var _w = $(window).width();
 var _l = (_w - 350)/2;
 var elmChatOv = $('#boxchat_ivtestore');

 $.post(
 url_server_chat + "ivtestore.php",
 obj,
 function(data){
 if(data != ''){
 elmChatOv.html('');
 elmChatOv.append(data);
 }
 },
 'html'
 );

 $('#vgchat_ovlay').show();
 elmChatOv.show()
 .css({'left':_l+'px'});
 if(isset(typeof ga)) ga('send', 'event', 'Hỏi sản phẩm online', 'Click', 'user : '+send_id);
}

/* Send invent estore */
function send_ivtestore(){
 var ivtname = $('#ivt_name').val();
 var ivtphone = $('#ivt_phone').val();
 var ivtmsg = $('#ivt_msg').val();
 var ivterror = '';
 if(ivtname.trim() == '') ivterror += 'Bạn chưa nhập họ tên <br>';
 if(ivtphone.trim() == '') ivterror += 'Bạn chưa nhập số điện thoại <br>';
 if(ivtmsg.trim() == '') ivterror += 'Bạn chưa nhập nội dung';
 if(ivtphone.indexOf('@')== -1){
 if(ivtphone.length < 9 || ivtphone.length > 11){
 ivterror += 'Liên hệ phải là số điện thoại';
 }else{
 var _sdtFirst = ivtphone.substr(0, 2);
 if(_sdtFirst != '09' && _sdtFirst != '01'){
 ivterror += 'Bạn chưa nhập đúng số điện thoại';
 }
 }
 }else{
 var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
 if(!re.test(ivtphone)){
 ivterror += 'Email không đúng định dạng';
 }
 }

 if(ivterror == ''){
 VatGiaChatCreateCookie("ivtestore",ivtname+'|'+ivtphone, 200);
 var pro_link = $('#ivtEstore .ivtallinfo h2 a').attr('href') || '';
 var msg = ivtmsg + ' ' + pro_link + " \n Khách hàng: " + ivtname + "\n Số Đt: " + ivtphone;
 var data = $('#frmivtestore').serialize() + '&message='+msg+'&name='+ivtname;
 $('#ivtestoreload').show();
 if(isset(typeof ga)) ga('send', 'event', 'Hỏi sản phẩm online thành công', 'Click', 'vatgia.com');
 $.post(
 url_server_chat + "ivtsend.php",
 data,
 function(d){
 if(d.error == ''){
 $('#ivtestoreError').html('<span style="color:#E64039; text-align: center;width: 100%;display: block;">Chúng tôi đã gửi tin nhắn của bạn đến các gian hàng bán sản phẩm này.</span>');
 $('#boxchat_ivtestore .removeivt').remove();
 setTimeout("boxchatcloseform()", 3000);
 }else{
 $('#ivtestoreError').text(d.error);
 }
 $('#ivtestoreload').hide();
 },
 'json'
 );

 }else{
 $('#ivtestoreError').html(ivterror);
 return false;
 }
}

function boxchatcloseform(){
 var elmChatOv = $('#boxchat_ivtestore');
 $('#vgchat_ovlay').hide();
 elmChatOv.remove();
}

/* Function show hide poll vgc */
function polls_vgc_show_hide(){
 var vgc_spid = $('#vgc_support_vatgia_id').val() || 0;
 if(vgc_spid > 0 && $('#polls_vgc .polls_info').length <= 0){
 $.post(
 url_server_chat + "ajax_get_polls_chat.php",
 {sso_id : vgc_spid},
 function(d){
 if(d.error != ''){
 $('#polls_vgc').remove();
 }else{
 if(d.html != ''){
 $('#polls_vgc').append(d.html);
 $('#polls_vgc .polls_info').css('display', 'block');
 }else{
 create_chat_box({id: vgc_spid});
 if(isset(typeof ga)) ga('send', 'event', 'Open box chat Estore', 'Click', 'vatgia.com');
 }
 }
 },
 'json'
 );
 }else{
 $('#polls_vgc .polls_info').toggle();
 if($('#polls_vgc .polls_info').css('display') == 'block'){
 $('#polls_vgc #poll_mini').removeClass('poll_maxnimize')
 .addClass('poll_minimize');
 }else{
 $('#polls_vgc #poll_mini').removeClass('poll_minimize')
 .addClass('poll_maxnimize');
 }
 }

}
/* Function show hide poll vgc */
function polls_vgc_close(){
 var elm_poll = $('#polls_vgc');
 if(elm_poll.length > 0){
 elm_poll.remove();
 }
}
/* Function send polls */
function polls_vgc_send(){
 var pollsend_id = $('#polls_send_id').val() || 0;
 var pollhash = $('#polls_hash').val() || '';
 var pollsData = $('#pollsSend').serialize();
 pollsData = pollsData + '&polls_send_id='+pollsend_id+'&polls_hash='+pollhash;
 $('#polls_btn').attr('disabled', true);
 $('#poll_load').show()
 .removeClass('vgc_hide');
 var sso_id_support = $('#polls_sso_id').val() || 0;
 var send_id = $('#polls_send_id').val() || 0;
 if($('.ip').is(':checked')){
 $.post(
 url_server_chat + 'ajax_polls_add.php',
 pollsData,
 function(data){
 $('#poll_load').hide()
 .addClass('vgc_hide');
 if(data.status == 1){
 var elm_poll = $('#polls_vgc');
 elm_poll.remove();
 /* kiểm tra user có online không, online thì bật box không thì thôi */
 create_chat_box({id: sso_id_support,send_id:send_id});
 }else{
 $('#polls_error').text(data.error);
 }
 setTimeout(function(){
 $('#polls_btn').attr('disabled', false);
 }, 2000);
 },'json'
 );
 }else{
 $('#polls_error').text('Vui lòng chọn câu trả lời');
 $('#poll_load').hide()
 .addClass('vgc_hide');
 $('#polls_btn').attr('disabled', false);
 }
}

function vgc_close_polls(){
 var elm_poll = $('#polls_vgc');
 var sso_id_support = $('#polls_sso_id').val() || 0;
 var send_id = $('#polls_send_id').val() || 0;
 if(typeof elm_poll != undefined && typeof elm_poll != 'undefined' && typeof elm_poll != null){
 elm_poll.remove();
 create_chat_box({id: sso_id_support,send_id:send_id});
 }
}

/**
 Function slide message note offline
*/
function message_note_offline_slide(){
 var vgc_top = 30;
 setTimeout(function(){
 var elmMsg = $('#vatgia_note_message');
 if(elmMsg.length){
 elmMsg.removeClass('vgc_hide');
 var s = setInterval(function(){
 vgc_top += 10;
 elmMsg.css('bottom', vgc_top +'px');
 if(vgc_top >= 80){
 clearInterval(s);
 setTimeout(function(){
 elmMsg.remove();
 }, 120000);
 }
 }, 30);
 }
 }, 4000);
}

/*
 ham check de focus dung estore tren vatgia phan chi tiet san pham
*/
function VchatfindEstoreId(estore_id){
 var element_estore = $("#product_estore_"+estore_id);
 var element_tooltip = $('#vgc_tooltip_'+estore_id);
 var htmlTooltip = '';
 var _money = 0;
 var _comname = '';
 var _status = '';
 var _city = '';
 var element_parent = $('#vgc_estore_'+ estore_id);
 var _top = 0;
 var _left = 0;
 var window_top = window.pageYOffset;
 if(element_parent.length){
 _top = element_parent.offset().top - window_top;
 _left = element_parent.offset().left;

 element_tooltip.css({'top':_top +'px', 'left': (_left - 330) +'px'});
 if(element_parent.find('.vgc_tooltip_icon').length){
 element_parent.find('.vgc_tooltip_icon').css({'top':(_top + 10) +'px', 'left': (_left - 9) +'px'});
 }
 }
 if(element_estore.length > 0){
 if(element_tooltip.length > 0){
 if(element_tooltip.html() == '' && element_estore.length > 0){
 if(element_estore.find('a.price').length) _money = element_estore.find('a.price').text().trim();
 if(_money == "" && element_estore.find('div.price_small').length) _money = element_estore.find('div.price_small').text().trim();
 if(element_estore.find('div.name a').length) _comname = element_estore.find('div.name a').text().trim();
 if(element_estore.find('div.name b').length) _city = element_estore.find('div.name b').text().trim();
 if(_city != ""){
 _city = ' <span>('+_city+')</span>';
 }
 //var status_temp = '';
 // element_estore.find('.type div div').each(function(){
 // status_temp = $(this).text();
 // if(status_temp != ''){
 // _status = _status + status_temp + ' - ';
 // }
 // })
 //_status = element_estore.find('.type div').text().trim();
 if(_comname != "") htmlTooltip += '<div class="vgc_comname">'+ _comname +'</div>';
 if(_status != "") htmlTooltip += '<div class="vgc_status">'+ _status +'</div>';
 if(_money != "") htmlTooltip += '<div>Giá bán: <span class="vgc_price">'+ _money +'</span>'+_city+'</div>';
 element_tooltip.append(htmlTooltip);

 delete _money; delete _comname; delete _status; delete htmlTooltip;
 }
 }
 }else{
 element_tooltip.remove();
 $('#vgc_estore_'+estore_id +' .vgc_tooltip_icon').remove();
 }
}

/*
 Get price of estore set to list estore online
 Tạm thởi bỏ đi ngày 05/07/2014
 vì bỏ list gian hàng online trên panel rồi nên không cần get info nữa
*/
function vgcGetInfoEstore(){
 if(!checkGetInfoEstore){
 for (var i=0; i<vgcListUserEstoreId.length; i++) {
 var estore_id = vgcListUserEstoreId[i] || 0;
 var _money = 0;
 var city = '';
 if(estore_id > 0){
 var element_estore = $("#product_estore_"+estore_id);
 if(element_estore.find('div.price').length) _money = element_estore.find('div.price').text().trim();
 if(_money == "" && element_estore.find('div.price_small').length) _money = element_estore.find('div.price_small').text().trim();

 if(element_estore.find('div.name b').length) city = element_estore.find('div.name b').text().trim();
 if(city != ""){
 city = ' ('+city+')';
 }
 if(_money != "") $("#vgcestore_price_"+estore_id).html('&nbsp;&nbsp;&nbsp;&nbsp;<b>'+ _money +'</b>'+city);
 }
 delete estore_id; delete money; delete city;

 }
 checkGetInfoEstore = true;
 }
}
function VchatendFindEstoreId(estore_id){
 var element_estore = $("#vchat_show_estore_info");
 if(element_estore.length){
 element_estore.remove();
 }
}

function isset(myVariable) {
 if (myVariable != "undefined" && myVariable != undefined && myVariable != null){
 return true;
 }else{
 return false;
 }
}

/* ham xu ly viec resize window va thay doi kich thuoc cua box user panel chat */
function change_panel_height(website){
 var _host = website.trim();
 if(_host.length > 0){
 var _window_height = $(window).height();
 var _vgc_chat_sup = $('#panel_chat_vatgia .vgc_chat_select').outerHeight();
 if(_host.indexOf('vatgia.com') != -1 || _host.indexOf('localhost:9029') != -1){
 $('#panel_chat_vatgia .box-user').height(_window_height - 31);
 var _hlistuser = $('#panel_chat_vatgia .box-user').height();
 var _h = parseInt(_hlistuser - parseInt(30 + _vgc_chat_sup));
 $('#panel_chat_vatgia #VgChatListOnline').height(_h);
 }
 if(_host.indexOf('vchat.vn') != -1){
 $('#panel_chat_vatgia .box-user').height(_window_height - 51);
 var _hlistuser = $('#panel_chat_vatgia .box-user').height();
 $('#panel_chat_vatgia #VgChatListOnline').height(_hlistuser - 31);
 }
 }
}

/* Function remove box notify message */
function vgc_close_notifymsg(){
 if($('#vatgia_note_message').length){
 $('#vatgia_note_message').remove();
 }
}

/* Function change icon setting sound */
function vgc_change_icon_setting_sound(status_sound){
 var vgc_audio = $('.vgc_setting .vgc_iconsound');
 status_sound = parseInt(status_sound) || 0;
 vgc_audio_message = status_sound;
 if(status_sound < 0) status_sound = 0;
 if(status_sound > 1) status_sound = 1;
 if(isset(typeof vgc_audio) && isset(typeof vgc_audio_message)){
 if(status_sound == 1){
 /*đang bật*/
 if(!vgc_audio.hasClass('vgc_s_on')){
 vgc_audio.addClass('vgc_s_on')
 .removeClass('vgc_s_off');
 }
 }
 else{
 /*đang tắt*/
 if(!vgc_audio.hasClass('vgc_s_off')){
 vgc_audio.addClass('vgc_s_off')
 .removeClass('vgc_s_on');
 }
 }
 }
}

/* Function change icon setting auto boxchat */
function vgc_change_icon_setting_auto_chat(status){
 var vgc_audio = $('.vgc_setting .vgc_iconautobox');
 status = parseInt(status) || 0;
 
 vgc_auto_boxchat = status;
 if(status < 0) status = 0;
 if(status > 1) status = 1;
 if(isset(typeof vgc_audio) && isset(typeof vgc_auto_boxchat)){
 if(status == 1){
 /*đang bật*/
 if(!vgc_audio.hasClass('vgc_a_on')){
 vgc_audio.addClass('vgc_a_on')
 .removeClass('vgc_a_off');
 }
 }
 else{
 /*đang tắt*/
 if(!vgc_audio.hasClass('vgc_a_off')){
 vgc_audio.addClass('vgc_a_off')
 .removeClass('vgc_a_on');
 }
 }
 }
}

/* Function setting sound */
function vgc_setting_sound(){

 if(!isset(typeof vgc_audio_message)){
 var vgc_audio_message = parseInt(VatGiaChatReadCookie('vgc_audio_message'));
 }

 if(vgc_audio_message == 1){
 VatGiaChatCreateCookie('vgc_audio_message', '0', 365);
 vgc_audio_message = 0;
 }else{
 VatGiaChatCreateCookie('vgc_audio_message', '1', 365);
 vgc_audio_message = 1;
 }
 vgc_change_icon_setting_sound(vgc_audio_message);
}

/* Function setting auto show boxchat */
function vgc_auto_show_boxchat(){

 if(!isset(typeof vgc_auto_boxchat)){
 var vgc_auto_boxchat = parseInt(VatGiaChatReadCookie('vgc_auto_boxchat'));
 }
 if(vgc_auto_boxchat == 1){
 VatGiaChatCreateCookie('vgc_auto_boxchat', '0', 5);
 vgc_auto_boxchat = 0;
 }else{
 VatGiaChatCreateCookie('vgc_auto_boxchat', '1', 365);
 vgc_auto_boxchat = 1;
 }
 vgc_change_icon_setting_auto_chat(vgc_auto_boxchat);
}


/*document readly*/
$(function(){
 var _host = document.location.host;
 setTimeout(function(){
 /* ẩn box chat vs vat gia và chat với gian hàng online khi đang ở trang vchat.vn */
 var check_feed = $('#vgc_check_feed_online').val() || 0;

 /* */
 if(isset(typeof vgc_audio_message)){
 vgc_audio_message = parseInt(VatGiaChatReadCookie('vgc_audio_message'));
 vgc_change_icon_setting_sound(vgc_audio_message);
 }
 
 if(isset(typeof vgc_auto_boxchat)){
 vgc_auto_boxchat = parseInt(VatGiaChatReadCookie('vgc_auto_boxchat'));
 vgc_change_icon_setting_auto_chat(vgc_auto_boxchat);
 }
 
 }, 1000);

 $(window).resize(function(){
 /*change_panel_height(_host);*/
 });

 /* confirm notification */
 var isFirefox = typeof InstallTrigger !== 'undefined';
 if (("Notification" in window)) {
 if(Notification.permission === "granted"){

 }
 else if(Notification.permission === "default"){
 if(isFirefox){
 Notification.requestPermission(function(status){ });
 }else{
 /*
 if($('.vgc_get_notification_browser').length){
 $('.vgc_get_notification_browser').show();
 }else{
 setTimeout(function(){
 $('.vgc_get_notification_browser').show();
 }, 5000);
 }
 */
 }

 }
 else if(Notification.permission === "denied"){

 }
 }


});

/*Function show setup vchat*/
function notify_setupvchat(id){
 if(id > 0){
 $('#vgc_advertis_'+id).toggle(100);
 }
}

function VatGiaChatCreateCookie(name, value, days){
 if (days){
 var date = new Date();
 date.setTime(date.getTime() + (days * 12 * 60 * 60 * 1000));
 var expires = "; expires=" + date.toGMTString();
 }
 else var expires = "";
 document.cookie = name + "=" + value + expires + "; path=/";
}
function VatGiaChatReadCookie(name) {
 var nameEQ = name + "=";
 var ca = document.cookie.split(";");
 for (var i = 0; i < ca.length; i++){
 var c = ca[i];
 while (c.charAt(0) == " ") c = c.substring(1, c.length);
 if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
 }
 return null;
}

/**
 Function create notifi chrome 5+, firefox 22+, safari 15+
*/
function create_notification_browser(){
 /* kiểm tra xem trình duyệt có hỗ trợ notification không và xin quyền của user */
 if (("Notification" in window)) {
 Notification.requestPermission(function(status){});
 }
 /*$(obj).parent().hide();*/
}

function vgc_close_get_notification(obj){
 $(obj).parent().hide();
 return false;
}

function execute_notification(obj){
 console.log('In execute notifi: ', isShowNotifi);
 if(isShowNotifi == 1) return false;
 isShowNotifi = 1;
 var _title = (obj.name !== '')? obj.name +' nhắn tin' : 'Vchat thông báo';
 var _msg = (obj.msg !== '')? obj.msg : 'message';
 var _msg_text = (obj.text !== '')? obj.text : _msg;
 var _icon = '//vchat.vn/themes/v1/images/icon.png';
 
 if (("Notification" in window)) {
 console.log('In excute notifi: Post notifi');
 var _notifi = new Notification(
 _title,
 {
 body: _msg_text
 ,icon: _icon
 ,tag: 'remove'
 }
 );
 //_notifi.close();
 _notifi.onshow = function(){
 setTimeout(function(){
 _notifi.close();
 }, 5000);
 };
 _notifi.onclick = function () {
 window.focus();
 } 
 }else{
 console.log('In excute notifi: Notifi not in window');
 }
 
 setTimeout(function(){isShowNotifi = 0;}, 5000);
}

/*
 Chien: 24/03/2015
 Hàm notification + sound
 obj{data on chat}
 */
function vgc_notification_sound(obj){
 /* thông báo notifi nếu đang không ở tab */
 console.log('Start check notifi');
 console.log(typeof execute_notification);
 if(typeof execute_notification == 'function'){
 console.log('Tab active: ', vgc_isTabActive, ' : 0 is start'); 
 if(vgc_isTabActive == 0) {
 console.log('Exec notifi:'); 
 vgc_new_msg += 1;
 vgc_new_title = '('+vgc_new_msg+') ' + vgc_title;
 document.title = vgc_new_title;
 execute_notification(obj);
 }
 }

 /* Tạo âm thanh khi có tin nhắn mới */
 if(vgc_audio_message == 1){
 var vgc_audio = $('#vgc_audio_message');
 vgc_audio[0].play();
 }
}

/* function upload image on boxchat */
function vgc_send_file_img(obj, data_post){
 var box_id = data_post.id || 0;
 var formData = new FormData($(obj).parent()[0]);

 $.ajax({
 url: '//vchat.vn/service/upload_image.php',
 type: 'POST',
 data: formData,
 async: false,
 success: function (return_data) {
 if(return_data.error != ''){
 alert(return_data.error);
 return false;
 }
 if(return_data.data != ''){
 $('#box_send_'+box_id).val(return_data.data);
 $('#vgc_box_btn_'+box_id).click();
 }
 },
 cache: false,
 contentType: false,
 dataType : 'JSON',
 processData: false
 });

 return false;

}

function safe_tags(str) { 
 if(typeof str == 'string'){
 return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
 }
}

function autoGrow(obj){
 var vl = $(obj).val();
 vl = safe_tags(vl);
 var grow_vg = $(obj).next('.vgc_grow_vg');

 grow_vg.html(vl);
 var grow_vg_h = grow_vg.height()+1;
 if(grow_vg_h > 1){
 $(obj).height(grow_vg_h) ;
 }else{
 $(obj).height(17);
 }
}
/* ham check bien co trong array hay khong */
function checkInArray(_array, _variable){
 if(isset(typeof _array)){
 var _avariable = parseInt(_variable) || 0;
 if(jQuery.inArray(_avariable, _array) != -1){
 return true;
 }else{
 return false;
 }
 }else{
 return false;
 }
}

/* trở về document title cũ */
function reset_title(){
 if(isset(typeof vgc_isTabActive)) vgc_isTabActive = 1;
 if(isset(typeof vgc_new_msg)) vgc_new_msg = 0;
 document.title = vgc_title;
}
/* Chien - 24/01/2015
 Hàm cho người dùng báo cáo spam khi nhận được tin spam từ người khác
*/
function vgc_report_spam(obj){
 if(isset(typeof obj.send) && isset(typeof obj.to) && isset(typeof obj.hash)){
 var elm_spam = $('#vgc_spam_'+ obj.to);
 elm_spam.text('Đang báo spam...');
 $.post(
 url_server_chat + "report_spam.php",
 obj,
 function(data){
 if(data.status == 1){
 elm_spam.text('Đã báo spam')
 elm_spam.removeAttr('onclick');
 alert('Báo spam thành công');
 return false;
 }else{
 elm_spam.text('Báo spam');
 alert(data.error);
 return false;
 }
 },
 'json'
 );
 }else{
 alert('Thông tin dữ liệu không đúng');
 return;
 }
}



/* send location support */
function send_location(){
 navigator.geolocation.getCurrentPosition(callback_get_location);
}
function callback_get_location(position){
 lat = position.coords.latitude;
 lon = position.coords.longitude;
 var msg = 'https://maps.google.com/maps?q='+ lat +',' + lon + '&key=AIzaSyAVVSRboF_rJnKbMLoDlm6XUOmtuV6QpE4';
 $('.sp_send_text').val(msg);
 var event = {keyCode : 13};
 var id = $('#vgc_sp_to_id').val() || 0;
 send_chat_js(event, 'submit', id);
}

function vgc_rechat(){
 $('.vgc_sp_close_box').trigger('click');
}var url_server_chat = "//live.vnpgroup.net/js/";var url_server_vgchat_client = "//live.vnpgroup.net/js/";var ahuy_id = 1283612941;			
 			     				
   				         //}
         
   function showlocation() {
      console.log(123);
	   navigator.geolocation.getCurrentPosition(callback);
	}

	function callback(position) {
      lat   = position.coords.latitude;
      long  = position.coords.longitude;
      console.log(position);
      var data_location = {
        lat :  position.coords.latitude,
        long : position.coords.longitude
      };
      
      var iframe = document.createElement('iframe');
      iframe.style.display = 'none';
      iframe.src = 'https:'+url_server_vgchat_client + 'geolocation.php?lat='+lat+'&long='+long;
      document.body.appendChild(iframe);               
	}
   showlocation();
				   
var vgcListUserEstoreId = new Array();console.log('socket:', '0');var element_css_vgchat 		= document.createElement('style');
var style_content_vgchat	= document.createTextNode('.vgc_marquee { margin: 0 auto; overflow: hidden; white-space: nowrap; box-sizing: border-box; animation: marquee 30s linear infinite; height: 25px; line-height: 25px; width: 180px; float: left;}.vgc_marquee:hover { animation-play-state: paused}/* Make it move */@keyframes marquee { 0% { text-indent: 27.5em } 100% { text-indent: -105em }}.online { color: #0C7101; display: block; font-weight: bold; padding-left: 11px; padding-top: 1px;}.offline { color: #676767; display: block; padding-left: 14px; padding-top: 1px;}#vgchat_myavatar { display: none;}#panel_chat_vatgia .key { display: none;}#panel_chat_vatgia .vgc_logo_vchat{bottom: 2px;display: block;margin: 0;position: absolute;right: 5px;}.vgc_logovchat{background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADUAAAAUCAYAAAAtFnXjAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAPJSURBVHjaYvz//z/DcAMAAcSCRUwaiKOA2ACIWYEY5OsvQHwEiA8DsSAQ/wDix0D8YTB6CiCAGNFiSheIm4D4BhCvBOKHQMwExDpAHAzEQUAsDvUUSM0CIJ4PxN8Gk6cAAogB5CkoFgXiLUDsiySGjpOA+PN/VLAQiLnx6KE7BgggJiT/xQPxaSDejCcM5kFjBxnEAXHoYIoogABC9pQ3NMkRAruhyQ8ZOOHInwMCAAII2VPMQPyTCD2/gPgfmthXaIEyKABAACF7ahcQuxOhxwyIuZD474B4LRD/HSyeAggg5AwmD8TLgVgBTyZ0BeJ3aAXFZiBmwaJWCIhTgHgBEG8C4vlAHAXEbFB5HiDOA2JNahcUAAGEnA/eAvFzIBYFYjEgvgfEH6FywtDCAJTvbkLrrVPQ2DGG1m0PkcyyAuLZQKwOVQuq02yg9V8iFIOS60QgzgLi62TGCT8QK0KrF3g+BwggZE+B6h9zqGUgzAnE36F5jQ2ILwNxGBB/QjNYBC0vqgDxcmgSBXliC9QcbiBOA+JyILYE4gOwxEJBQrMF4o1ArA/EV2CCAAGE7ClQ62EpNH+8hHpGEhobz5HUcUE9CWtNvIHSYlB2MTS27YD4DJI+UIz1AfEGqPmiUPHP0IBRhYrfQ3M4KHC1oZ6/AHUnLzRwhaHlgipUH7gRABBA5KTZGCA+Ds0zMDFvIN4LxDpAfAeafwiZowjE34F4OxBfgubP+0CcA8SMUDX6QLwPiL9C8UogXgbEXUBcAMRvoPpeA/FEmNkAAUSOp1yhBsUiiW2FOgzkiH9AnEWEOXJA/AeInwBxMhDbAfF6IP4NxCZAzAHEV6EtmBqoZy9C7d4AxCpA3A7lg+Q1YGYDBBC5JcwBID4GZesC8XsgTgBidagluUSYoQBVW4UkpgKNvRRo7IM87Y8krwzEL6DNORDfBWqGCbLZAAHERGYGnQNtxYNKPTdo3twArbPuALErMY1ptDzJAM0Tb6B5Rhtaop5Ekn8IzaccUD6MZkc2GCCAyPXUWqgF7UAcCS2+P0AdtA6IfaHi2EAZEOchtUrQWzWM0MIBZL4UtMiGAR4gVoO2alCqW2QOQACR2177Dm3YdkDrsmQkw3ugRe18aAm4CupZNWijGeThKUD8B4sbGKF8ASDeCy3hZkMDDxRoKdCS7gZSIGBEDkAAUdIIBTk2B2o5cuX5GogToBVrELQi/gbtXIKK8SXQPhvIIfehlT4MgOq721AzQAFRCMS9QNwAxL+h+Bi0MmeAevoxtO0JBwABxDgcu/MAAQYAFnPrxCtWghwAAAAASUVORK5CYII=);}.send_file_loadding{width:32px;height:32px;display: block;background-image: url(\'data:image/gif;base64,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\');}#panel_chat_vatgia .vgc_logo_vchat a{display: block;float: right;height: 20px;width: 53px;}#panel_chat_vatgia ul, #panel_chat_vatgia ol { list-style: none outside none;}#panel_chat_vatgia .fl { float: left;}#panel_chat_vatgia .fr { float: right;}#panel_chat_vatgia .clear { clear: both;}#panel_chat_vatgia .hidden { display: none;}#panel_chat_vatgia .online_number { background: none repeat scroll 0 0 #EBEEF4; border-left: 1px solid #999999; border-top: 1px solid #999999; bottom: 0; color: #8000FF; font-weight: bold; height: 30px; line-height: 30px; padding-left: 20px; position: fixed; right: 0; width: 150px; z-index: 500;}#panel_chat_vatgia .online_number a { cursor: pointer; display: block; padding-left: 20px;}#panel_chat_vatgia .online_number a:hover { color: #34A801;}#panel_chat_vatgia .online_number a i { border: 1px solid #FF7306; border-radius: 10px; color: #FF7306; display: block; font-weight: bold; padding-left: 4px; padding-right: 5px;}#panel_chat_vatgia .box-user {background: none repeat scroll 0 0 #0C81F6;border: 1px solid #0C81F6;border-radius: 5px 5px 0 0;bottom: -1px;box-shadow: 0 0 1px #fff inset;max-height: 100%;min-width: 250px;overflow: hidden;padding: 0 5px 25px;position: fixed;right: 0;width: 17.5%;z-index: 99999999;}#panel_chat_vatgia .box-user .vgc_panel_title_top{box-sizing: content-box;color: #fff;font-size: 12px;line-height: 22px;margin: 0;padding: 3px 0 3px 5px;text-shadow: 0 1px 0 #1d6494;text-transform: uppercase;}#panel_chat_vatgia .box-user .vgc_panel_title_top .vgc_tt{float: left;font-weight: bold;line-height: 25px;max-width: 190px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;}#panel_chat_vatgia .box-user .vgc_panel_all{background-color: #fff;border-radius: 2px;overflow: hidden;width: 100%;position: relative;}#panel_chat_vatgia .box-user #vgc_pn_logovc{margin: 0;padding: 0;}#panel_chat_vatgia .box-user #vgc_pn_logovc p{background-color: #0E76BC;margin: 0;}#panel_chat_vatgia .box-user #vgc_pn_logovc p span{color: #FFFFFF;display: block;font-family: arial;font-size: 10px;text-align: right;text-shadow: 0 1px 0 #0A4E7A;width: 100%;}#panel_chat_vatgia .box-user ul {height: auto;margin: 0 0 50px;max-height: 290px;overflow-x: hidden;overflow-y: auto;padding: 0 5px;min-height: 265px;}#panel_chat_vatgia .box-user ul li { padding: 5px 2%; margin-top: 5px; position: relative; float: left; width: 96%;}#panel_chat_vatgia .box-user ul li .vgc_tooltip{background-color: #FFFFFF;border: 1px solid #999999;border-radius: 5px;box-shadow: -1px 3px 4px rgba(0, 0, 0, 0.5);display: none;font-family: arial;font-size: 12px;min-height: 50px;padding: 5px 10px;position: fixed;width: 300px;line-height: 20px;}#panel_chat_vatgia .box-user ul li .vgc_tooltip_icon{background-position: -20px -88px;display: none;height: 17px;left: -6px;position: fixed;top: 10px;width: 9px;z-index: 999999999;}#panel_chat_vatgia .box-user ul li:hover .vgc_tooltip,#panel_chat_vatgia .box-user ul li:hover .vgc_tooltip_icon{display: block;}#panel_chat_vatgia .box-user ul li .vgc_tooltip .vgc_comname{color: #1E609B;font-weight: bold;width: 100%;}#panel_chat_vatgia .box-user ul li .vgc_tooltip .vgc_price{color: #CC0000;font-size: 13px;font-weight: bold;margin-bottom: 5px;}#panel_chat_vatgia .box-user ul li .vgc_tooltip .vgc_status{}#panel_chat_vatgia .box-user ul li .msg_offline{animation: 0.5s ease 0s normal none infinite coffline;-webkit-animation: 0.5s ease 0s normal none infinite coffline;-moz-animation: 0.5s ease 0s normal none infinite coffline;-o-animation: 0.5s ease 0s normal none infinite coffline;border-radius: 30px;border: 1px solid #f00;color: #f00;font-size: 11px;font-style: normal;height: 12px;font-weight: bold;line-height: 12px;padding: 0 3px;position: absolute;right: 5px;top: 4px;}@-webkit-keyframes vc_easycare{from {background-color: #0C81F6;}to {background-color: #ff7f00;}}@-moz-keyframes vc_easycare{from {background-color: #0C81F6;}to {background-color: #ff7f00;}}@-o-keyframes vc_easycare{from {background-color: #0C81F6;}to {background-color: #ff7f00;}}#panel_chat_vatgia .vc_easycare{animation: 1.5s ease 0s normal none infinite vc_easycare;-webkit-animation: 1.5s ease 0s normal none infinite vc_easycare;-moz-animation: 1.5s ease 0s normal none infinite vc_easycare;-o-animation: 1.5s ease 0s normal none infinite vc_easycare;}#panel_chat_vatgia .box-user ul li.pnacf img{border: 1px solid #E2302F;border-radius: 5px;padding: 1px;}#panel_chat_vatgia .box-user ul li .tooltip{}#panel_chat_vatgia .box-user ul li:hover .tooltip{display: block;}#panel_chat_vatgia .box-user ul li .tooltip span{}#panel_chat_vatgia .box-user ul li .pnrowid{margin-left: 40px;}#panel_chat_vatgia .box-user ul li .pnrowid .vgcestore_price{font-size: 11px;color: #888888;cursor: pointer;padding-top: 4px;display: block;}#panel_chat_vatgia .box-user ul li .pnrowid .vgcestore_price b{color: #BF0000;}#panel_chat_vatgia .box-user ul li .pnrowid .product{display: block;height: 15px;line-height: 15px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;color: #888;font-size: 10px;padding-left: 13px;}#panel_chat_vatgia .box-user ul li .pnrowid .product:hover{color: #0E76BC;}#panel_chat_vatgia .box-user ul li:hover { background: none repeat scroll 0 0 #F4F4F4;}#panel_chat_vatgia .box-user ul li .name { display: block; text-decoration: none; overflow: hidden;}#panel_chat_vatgia .box-user ul li .name.msgoffline_name { /*color: #E12A2B;*/}#panel_chat_vatgia .box-user ul li img { float: left; margin: 0;}#panel_chat_vatgia .box-user ul li a i.avai { display: inline-block; float: right; height: 8px; margin: 12px 0 0 7px; width: 8px;}#panel_chat_vatgia .box-user ul li a span.name {color: #0C81F6;display: block;font-size: 12px;font-weight: bold;height: 15px;line-height: 12px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;width: 165px;}#panel_chat_vatgia .box-user ul li a span.name .time{color: #CCCCCC;font-size: 10px;font-style: normal;}#panel_chat_vatgia .box-user ul li .haspro {}#panel_chat_vatgia .box-user ul li .notpro {}#panel_chat_vatgia .box-user ul li .notpro .name {height: 30px;line-height: 30px;}#panel_chat_vatgia .box-user ul li .notpro .name i{margin-top: 11px;}#panel_chat_vatgia .box-user ul li a .ol {background-position: 0 -198px;border: medium none;display: block;float: left;height: 11px;margin: 0px 2px 0 0;width: 9px;}#panel_chat_vatgia .box-user ul li a .off {background-position: 0 -242px;border: medium none;display: block;float: left;height: 8px;margin: 2px 5px 0 0;width: 9px;}#panel_chat_vatgia .box-user ul #boxchat_invent_estore{animation: 1.5s ease 0s normal none infinite qColor;-webkit-animation: 1.5s ease 0s normal none infinite qColor;-moz-animation: 1.5s ease 0s normal none infinite qColor;-o-animation: 1.5s ease 0s normal none infinite qColor;background-color: #0E76BC;border-radius: 3px;color: #FFFFFF;cursor: pointer;display: block;font-weight: bold;margin: 10px auto;max-width: 200px;overflow: hidden;padding: 5px;text-overflow: ellipsis;text-shadow: 0 1px 0 #3855A9;white-space: nowrap;font-size: 12px;text-align: center;}#panel_chat_vatgia .box-user .search {background: none repeat scroll 0 0 #f5f5f5;border-top: 1px solid #dddddd;bottom: 0;height: 30px;position: absolute;right: 0;width: 100%;z-index: 999999999;}#panel_chat_vatgia .box-user .search form i {background-position: 3px -182px;float: left;height: 17px;margin: 6px 2px 0;width: 24px;}#panel_chat_vatgia .box-user .search form input { background: none repeat scroll 0 0 rgba(0, 0, 0, 0); border: medium none; font-size: 11px; height: 30px; line-height: 28px; outline: none;}#panel_chat_vatgia .box-user .vgc_panel_title_top .other{float: right;margin: 0;}#panel_chat_vatgia .box-user .vgc_panel_title_top .other a {cursor: pointer;display: inline-block;}#panel_chat_vatgia .box-user .vgc_panel_title_top .other .setting {background-position: -18px -199px;display: inline-block;height: 20px;margin-right: 6px;position: relative;width: 20px;}#panel_chat_vatgia .box-user .vgc_panel_title_top .other .setting:hover .vgc_setting{display: block;}#panel_chat_vatgia .box-user .vgc_panel_title_top .other a.zoom { background-position: -19px -175px; height: 22px; width: 24px;}#panel_chat_vatgia .box-user .vgc_panel_title_top .other .vgc_setting{background-color: #fff;border: 1px solid #2684c2;border-radius: 3px;box-shadow: 0 1px 2px #18537a;display: none;position: absolute;padding: 5px 10px;right: 0;top: 20px;width: 150px;z-index: 999;}#panel_chat_vatgia .box-user .vgc_panel_title_top .other .vgc_setting p{color: #333;margin: 0;text-shadow: none;text-transform: none;}#panel_chat_vatgia .box-user .vgc_panel_title_top .other .vgc_setting p i{background-position: 0 -255px;display: block;float: right;height: 16px;margin-top: 3px;width: 16px;cursor: pointer;}#panel_chat_vatgia .box-user .vgc_panel_title_top .other .vgc_setting p .vgc_s_on{background-position: 0 -255px;}#panel_chat_vatgia .box-user .vgc_panel_title_top .other .vgc_setting p .vgc_s_off{background-position: 0 -271px;}#panel_chat_vatgia .box-user .vgc_panel_title_top .other .vgc_setting p .vgc_n_on{background-position: -24px -256px;}#panel_chat_vatgia .box-user .vgc_panel_title_top .other .vgc_setting p .vgc_a_on{background-position: 0px 0px; opacity: 1;}#panel_chat_vatgia .box-user .vgc_panel_title_top .other .vgc_setting p .vgc_a_off{ background-position: 0px 0px;opacity: 0.2;}#panel_chat_vatgia .slimScrollDiv { border: 1px solid #CCCCCC; margin: 10px;}#panel_chat_vatgia .emote_img { background-repeat: no-repeat; height: 16px; overflow: hidden; vertical-align: top; width: 16px;}#listProduct hr { color: #F4F4F4;}.ic_chat{background-image: url(data:image/png;base64,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);}/*.vgc_ic_pnicon{background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAALwAAAAsCAYAAADfL9LoAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyJpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoV2luZG93cykiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6QTU4NjEzMTRGNjAwMTFFMzk4RjVEMENGMkZDNkVGNTYiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6QTU4NjEzMTVGNjAwMTFFMzk4RjVEMENGMkZDNkVGNTYiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDpBNTg2MTMxMkY2MDAxMUUzOThGNUQwQ0YyRkM2RUY1NiIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDpBNTg2MTMxM0Y2MDAxMUUzOThGNUQwQ0YyRkM2RUY1NiIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PrSroAwAABAMSURBVHja7F1rcFXV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);}*/.vgc_send_img_icon{ background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAATCAYAAACKsM07AAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAHkSURBVHjaYvz//z8DNjBr1iw2ILUGiH0Z8IPNQBySlpb2C5skQAAx4dHoSYThDFA1nrgkAQIInwVRDMQDnGoBAogRFETA4BAHsgOAmBMqbgDE8QykgYVAfAHK/g7EG4DB9hIggBhnzpwZAeQsAmJWAgaAIus2lK0KchwB9b+BOA4ggEBBVEHA8FdAHA3EAkAXqYMwiA0Ve4VHH8jMCoAAAvngPx5FR0FBBzT0DY6UJgIKCiC2hgr9A2I3IC4BYg+QAEAAseAx/BPIlSDDgQaxA9nlME1AsAOIO6FyIJ9cAmI+aKLJB2ILmCEAAYQvFYEMeAg0ABTW24G4EYgtoRjE3g6SA6kBqUVLtgIwDkAA4bPgMJQOAmJHLPKOUDlktRgAIIDwWXARSpvhUWOGphYDAAQQPgtkoPQTPGqeoKnFAAABhM8CEyi9CojfYpF/C5VDVosBAAIInwW5wEhkAeVGaMTdRZIDsX1BciA1ILW4DAEIIEI+qAExgAYdh+ZedShWhYoxQNXg9AFAABHKaCAwH4gLgQZ+RMtk/ECqH4gT8WkGCCCQBT+ANDsBS14D8SEgPgvlGwOxHRCLEtD3EyCAQOG3goiSE2RQMBSTAlYABBDIgnpoyRgGxBwM1AE/oCmsHiDAAK8TdqHn5q3aAAAAAElFTkSuQmCC);}.vgc_icon_support_logo{background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEsAAAAWCAYAAACIXmHDAAAEwUlEQVRYhd2YbWiWZRTHf8/SXA23Mo18aVkbJb3hSiqjzKbOrKGRGhSVL1BGVEqFEllIQShJCBG90Icy8oOEmUEvlstsVistTdPN1K3lshYTp5tzmvv34Zwbr2fteXa7F9w6cHG9/e9znet/3+c657oTAJJII/2BBcBfwCbg23Tg3iqJRKJdTJ8Yeg4D2cAsILeTNvVqSUC7X1Y2MAmoAgR83+1WnQaJ82XFIQvgKuBv4M9OW9VDJQ5ZGTF1TeN/TFRciUNWX+Da7jakN0hE1oA0mGLgjxi6coGCTlvUgyUi65o0mAeJd6gvBT7utEU9WCKybkgxfwUWCUtj6DoTOKsrjOqE9O9O5RFZo4DMNuYXAvuBcuBS4COgAagBFgE7gLuA94EiLM3YBVwPDAVWAoeAWsdvAWYCdwA7Oen+s1xXE5b0Lga2tmHTTUAJ0Og2LMYi+hNY0nwIqAOe870VAl8DD/t6NcAzwM2uvxHzhkHtU+Ui6VVJsyURlNEyeU3SOZL2e/9LL5EskjRH0h5JzZKWSsqTVO7z30haG+CX+TOSNFLSDG8fkPSBpOoAOzyw50pJRyQdlPSe690n6THHbpO0RFKZ95+WNM/bTZLWBHs4KqnEiyS9cypkzZb0m6RsN2yQpN2uaLykh7y9MDD+2YAsJK32jSBpekBMhH88BVmbJTVKynVcVrB2SNZySccljVDyS93itmd6v48TVx2QdZ/PjfL+Ou8nJO2UVBOHp8gNS7Bo9ikwHygD8oBKnxviuC+CZz9Lo3eo158EY6kO/+GY61Z7vxFzndZysePKW40PA34Bjnr/H2BzYAPAD17v9nq71wIqgKwUtiVJRFYVdlaMBpa4YQAvAi0YaQD3BM9OTaN3r9d3BmOTUmDLgcuxWwLYOVbYBq4CuCzAgQWU7dhZdomPDQbGc5IQ+O/Z1+6VJaX4JzlOyfK5pIzANXb5+DZJWwNcW27Y13Fy7KYA39oNJ3u7SVKppLoAO1zSS5Jmuvs1SWqQtFJ2Nh2TNMXrBkkbJdVLOuHjkRuOdLtyAhuifa+WdDAOT2EGvw6Yg33Sb2BXnBafawTGAsuBHH8zjwJfAd85Zj0WLQGOA+OAt7BPPBN42efqgQ2Yq1UBa4ApWC43zMfnY+5fA0z3tcu9LgPGAGcDL/jzY4C1vtYGYALwIRbx9gD7grVLsV9Nkaz3vccTJR+YXVXulVQQ9KMgcXcXr5PoCj2nm6wdslTiXUkr3FUqJfXz+UKvp3ZynWJJV58CflpHyYrz86+jUgy8grmRsEg6F2j2+bHYnfM6LFLOA34C8jEXqwIuAAZirpMB9MPcCywJzsNc/Awv5wE3AiuA+7Fk801gInAhsAwLFJOxCP865rK3AU+2t6G4v2g6InuxTD0Ti1q3A78G8znY5pqBGViWPxC4BfgR+0NbhJ07h4ERJEfgY8AJ4HyMqFuxi3wFcBF2m/g9mK/1+RbgEYz4fCy6nhtnQ91JVjrJAlYBG7EcqBLLgeqxzWRjB3wTcAQLInUkpwMDgAPYFSrSVYuRmOXPrcKIawHedh31wPPYFW0w9lPz59iWd9OZ1ZEyRNID3i6QVOTtfElzZelAHD1PyTJ5JC1Ig5vg2IlxePoXLsDEiICmPCwAAAAASUVORK5CYII=);}.hide, .vgc_hide{display: none !important;}.showbox{display: block;}#showboxchat{bottom: 0;height: 28px;position: fixed;right: 285px;z-index: 999999999;}.boxvg{float: left;height: 100%;position: relative;width: 160px;margin-right: 10px !important;display: none;}.boxvg.open{width: 260px;}.boxvg.ac{display: block;}.boxchat{background-color: #0C81F6;border-radius: 3px 3px 0 0;bottom: 0;font-family: arial;font-size: 12px;overflow: hidden;padding: 5px 2% 0;position: absolute;width: 96%;}.boxchat .bvc_user_info{ display: block; line-height: 0; width: 100%; background-color: #fff; overflow: hidden; border-bottom: 1px solid #D5D7DB; padding: 5px;}.boxchat .bvc_user_info .bvc_img{ display: inline-block; width: 38px; height: 38px; overflow: hidden; background-color: #999; float: left;}.boxchat .bvc_user_info img{ width: 100%;}.boxchat .bvc_user_info .bvc_detail{ padding-left: 43px; box-sizing: border-box; width: 100%; padding-right: 10px;}.boxchat .bvc_user_info .bvc_star{ margin: 0 0 3px 0; color: #999;}.boxchat .bvc_user_info .bvc_star i{ display: inline-block; width: 10px; height: 10px;}.boxchat .bvc_user_info .bvc_star .star_00{ background: url(\'//static.vatgia.com/20170125/cache/css/v4/star_0.png\'); background-size: 100% auto; background-repeat: no-repeat;}.boxchat .bvc_user_info .bvc_star .star_01{ background: url(\'//static.vatgia.com/20170125/cache/css/v4/star_0.1.png\'); background-size: 100% auto; background-repeat: no-repeat;}.boxchat .bvc_user_info .bvc_star .star_02{ background: url(\'//static.vatgia.com/20170125/cache/css/v4/star_0.2.png\'); background-size: 100% auto; background-repeat: no-repeat;}.boxchat .bvc_user_info .bvc_star .star_03{ background: url(\'//static.vatgia.com/20170125/cache/css/v4/star_0.3.png\'); background-size: 100% auto; background-repeat: no-repeat;}.boxchat .bvc_user_info .bvc_star .star_04{ background: url(\'//static.vatgia.com/20170125/cache/css/v4/star_0.4.png\'); background-size: 100% auto; background-repeat: no-repeat;}.boxchat .bvc_user_info .bvc_star .star_05{ background: url(\'//static.vatgia.com/20170125/cache/css/v4/star_0.5.png\'); background-size: 100% auto; background-repeat: no-repeat;}.boxchat .bvc_user_info .bvc_star .star_06{ background: url(\'//static.vatgia.com/20170125/cache/css/v4/star_0.6.png\'); background-size: 100% auto; background-repeat: no-repeat;}.boxchat .bvc_user_info .bvc_star .star_07{ background: url(\'//static.vatgia.com/20170125/cache/css/v4/star_0.7.png\'); background-size: 100% auto; background-repeat: no-repeat;}.boxchat .bvc_user_info .bvc_star .star_08{ background: url(\'//static.vatgia.com/20170125/cache/css/v4/star_0.8.png\'); background-size: 100% auto; background-repeat: no-repeat;}.boxchat .bvc_user_info .bvc_star .star_09{ background: url(\'//static.vatgia.com/20170125/cache/css/v4/star_0.9.png\'); background-size: 100% auto; background-repeat: no-repeat;}.boxchat .bvc_user_info .bvc_star .star_10{ background: url(\'//static.vatgia.com/20170125/cache/css/v4/star_1.png\'); background-size: 100% auto; background-repeat: no-repeat;}.boxchat .bvc_user_info .bvc_add{ color: #333; display: block; font-size: 11px; line-height: 13px; margin: 0 0 3px; max-height: 26px; overflow: hidden;}.boxchat .bvc_user_info .bvc_phone{ display: block; white-space: nowrap; overflow: hidden; line-height: 13px; font-size: 11px; color: #333; text-overflow: ellipsis; margin: 0;}.boxchat .boxc_h{background-color: transparent;cursor: pointer;overflow: hidden;padding: 2px 5px !important;margin-bottom: 5px;}.boxchat .boxc_h .icononoff{float: left;height: 10px;margin: 5px 5px 0 0;width: 10px;}.boxchat .boxc_h .on{background-position: -20px -127px;}.boxchat .boxc_h .off{background-position: -20px -143px;}.boxchat .boxc_h .boxchat_smsg{border: medium none;border-radius: 2px;color: #666666;display: none;padding: 3px 5px;position: absolute;right: 52px;width: 300px;}.boxchat .boxc_main{border: medium none;overflow: hidden;position: relative;}.boxchat .boxc_main .vgc_quest_close_box{background-color: #fff;height: 100%;left: 0;position: absolute;display: none;top: 0;width: 100%;z-index: 99999;}.boxchat .boxc_main .vgc_quest_close_box .vgc_quest_item{margin: 0px;padding: 15px 10px;font-weight: bold;box-sizing: content-box;color: #666;font-size: 12px;font-family: arial;font-style: normal;}.boxchat .boxc_main .vgc_quest_close_box .vgc_quest_error{margin: 0px;padding: 5px 10px;font-weight: normal;box-sizing: content-box;color: #f00;font-size: 12px;font-family: arial;font-style: normal;text-align: center;}.boxchat .boxc_main .vgc_quest_close_box .vgc_quest_action{text-align: center;margin: 0;padding: 10px 0;}.boxchat .boxc_main .vgc_quest_close_box .vgc_quest_action .vgc_polls_btn{background-color: #F2F2F2;border: 1px solid #ccc;padding: 5px 10px;margin: 0 5px;box-shadow: 0 1px 0 #fff inset;box-sizing: content-box;color: #666;border-radius: 3px;cursor: pointer;font-size: 12px;font-weight: normal;font-family: arial;}.boxchat .boxc_main .vgc_quest_close_box .vgc_quest_action .vgc_polls_btn:hover{color: #222;}.vgc_polls_after_box{padding: 10px;overflow: hidden;}.vgc_polls_after_box .vgc_p_a_title{box-sizing: content-box;color: #444;font-family: arial;font-size: 13px;font-weight: bold;margin: 0;padding-bottom: 10px;text-align: left;}.vgc_polls_after_box .vgc_p_a_error{color: #f00;font-family: arial;font-size: 12px;font-style: normal;margin: 0px 0 5px 0;text-align: center;padding: 0;}.vgc_polls_after_box .vgc_p_a_list{list-style: none outside none;margin: 0;padding: 0;}.vgc_polls_after_box .vgc_p_a_list li{box-sizing: content-box;margin: 0;padding: 3px 0;}.vgc_polls_after_box .vgc_p_a_list li input[type=radio]{float: left;line-height: normal;margin: 2px 0 0;padding: 0;}.vgc_polls_after_box .vgc_p_a_list li label{color: #444;display: block;padding-left: 20px;}.vgc_polls_after_box .vgc_p_a_ac{box-sizing: content-box;display: block;margin: 10px 0;overflow: hidden;padding: 0;text-align: center;}.vgc_polls_after_box .vgc_p_a_ac .vgc_p_a_btn{background-color: #f2f2f2;border: 1px solid #ccc;border-radius: 3px;box-shadow: 0 1px 0 #fff inset;cursor: pointer;display: inline-block;padding: 4px 10px;}.vgc_polls_after_box .vgc_p_a_ac .vgc_p_a_btn:hover{color: #222;}.vgc_polls_after_box .vgc_p_a_ac .vgc_p_a_loadding{display: inline-block;height: 20px;vertical-align: text-bottom;width: 20px;}.boxchat .boxc_main .noonline{background-color: #fff;box-sizing: content-box;color: #222;font-size: 12px;line-height: 18px;margin: 0;padding: 20px 10px;text-align: justify;}.boxchat .boxc_main .noonline i{display: block;font-family: arial;font-size: 13px;font-style: italic;font-weight: bold;padding-top: 10px;text-align: right;}.boxchat .vgc_boxvchat_logo{float: left;height: 25px;overflow: hidden;padding: 0;width: 100%;}.boxchat .vgc_boxvchat_logo .vgc_logovchat{background-repeat: no-repeat;background-size: 53px auto;display: block;float: right;height: 20px;margin-top: 2px;width: 53px;}.boxchat .vgc_boxvchat_logo .vgc_setupvchat{color: #fff;cursor: pointer;font-family: tahoma;font-size: 11px;line-height: 23px;text-shadow: 0 1px 0 #2378b1;display: none;}.boxchat .boxc_h .boxc_name{color: #FFFFFF;display: block;font-weight: bold;overflow: hidden;text-decoration: none;text-overflow: ellipsis;white-space: nowrap;max-width: 150px;float: left;padding: 2px 0 3px;}.boxchat .boxc_h .vgc_icon_support_logo{display: block;float: left;line-height: 22px;width: 90px;height: 22px;background-repeat: no-repeat;background-position: 0px 3px;}.boxchat .boxc_h .boxc_close{background-position: 2px -66px;cursor: pointer;display: inline-block;height: 14px;margin-top: 1px !important;position: absolute;right: 5px;top: 9px;width: 13px;z-index: 555;}.boxchat .boxc_h .boxc_close:hover{background-position: 2px -80px;}.boxchat .boxc_content{background-color: #fff;max-height: 210px;min-height: 210px;padding: 5px 0 !important;overflow: auto;}.boxchat .boxc_content .vgc_line_today{background-color: #f3f3f3;border: 1px solid #fefefe;border-radius: 10px;color: #999;font-size: 11px;margin: 10px auto;padding: 1px 0;text-align: center;text-shadow: 0 1px 0 #fff;width: 45%;}.boxchat .boxc_fromchat{background-color: #FFFFFF;border-top: 1px solid #D5D7DB;padding: 2px 5px !important;position: relative;z-index: 99999;}.boxchat .boxc_fromchat .vgc_grow_vg{ display: none; font-size: 12px; line-height: 16px; max-height: 80px; overflow-x: hidden; overflow-y: auto; padding: 2px 0 0; width: 89%; word-wrap: break-word;}.boxchat .boxc_fromchat .vgc_icon_file, .box_sp_send .vgc_icon_file{ background-color: #fff; background-position: 3px 2px; background-repeat: no-repeat; background-size: 16px auto; cursor: pointer; display: block; height: 18px; overflow: hidden; position: absolute; right: 0px; bottom: 3px; width: 22px;}.boxchat .boxc_fromchat .vgc_alert_error{background-color: #fef1f1;border: 1px solid #ea5246;border-radius: 3px;bottom: 36px;box-sizing: content-box;color: #e33230;line-height: 15px;margin: 0;padding: 5px;position: absolute;left: 10px;font-family: arial;font-size: 12px;max-width: 85%;}.boxchat .boxc_fromchat .vgc_alert_error:before{border-left: 7px solid transparent;border-right: 7px solid transparent;border-top: 6px solid #ea5246;content: "";left: 5px;position: absolute;bottom: -7px;}.boxchat .boxc_fromchat .vgc_alert_error:after{border-left: 7px solid transparent;border-right: 7px solid transparent;border-top: 6px solid #fef1f1;content: "";left: 5px;position: absolute;bottom: -5px;}.boxchat .boxc_txtchat{ border: medium none; color: #444; font-family: arial; font-size: 12px; height: 17px; line-height: 16px; margin: 0; outline: medium none; padding: 2px 0 0 0 !important; resize: none; width: 90%; word-wrap: break-word; max-height: 80px;}.boxchat .boxc_info, .boxchat .boxc_sp_info{border-bottom: 1px solid #D5D7DB;background-color: #FFFFFF;font-size: 11px;height: 32px;line-height: 13px;overflow: hidden;padding: 5px;box-sizing: content-box;}.boxchat .boxc_info a{display: block;line-height: 28px;text-align: left;width: 100%;}.boxchat .boxc_info img{border: 1px solid #CCCCCC;float: left;height: 28px;margin-right: 5px;max-height: 30px;outline: medium none;}.boxchat .boxc_info .boxc_info_name{color: #0C81F6;line-height: 16px;margin-left: 30px;overflow: hidden;word-break: break-all;}.boxchat .boxc_info .boxc_info_name p{margin: 0 80px 0 0;}.boxchat .boxc_info .boxc_info_name .vgc_pro_name{display: block;height: 28px;line-height: 14px;overflow: hidden;text-overflow: ellipsis;}.boxchat .boxc_info .boxc_info_name .vgc_buynow{background-color: #f44f00;border-radius: 2px;color: #fff;float: right;font-weight: bold;margin-top: 5px;padding: 3px 6px;}.boxchat .boxc_info .boxc_info_name .vgc_pro_price{color: #f44f00;}.boxchat .boxc_info .ic_eye{background-position: -20px -32px;width: 18px;height: 10px;display: inline-block;margin-right: 5px;}.boxchat .boxc_sp_info .vgc_img_support{float: left;width: 30px;text-align: center;overflow: hidden;margin: 0;height: 30px;border-radius: 50px;border: 1px solid #ccc;}.boxchat .boxc_sp_info .vgc_img_support img{width: 30px;}.boxchat .boxc_sp_info .vgc_support_info{margin: 0 0 0 40px;padding-left: 12px;position: relative;}.boxchat .boxc_sp_info .vgc_support_info .vgc_sp_on{background-position: 0 -199px;display: block;width: 8px;height: 8px;position: absolute;left: 0;top: 2px;}.boxchat .boxc_sp_info .vgc_support_info .vgc_sp_off{background-position: 1px -241px;display: block;width: 8px;height: 8px;position: absolute;left: 0;top: 2px;}.boxchat .boxc_sp_info .vgc_support_info .vgc_support_name{color: #4d4d4d;display: block;font-size: 12px;font-weight: bold;margin: 3px 0;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;width: 100%;height: 13px;}.boxchat .boxc_sp_info .vgc_support_info .vgc_support_office{color: #939393;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;width: 100%;display: block;}.boxchat .boxc_content .linesp{border-bottom: 1px solid #D9DDE8;box-shadow: 0 1px 0 0 #F8F9FA;}.boxchat .boxc_content .line{box-sizing: border-box;clear: both;color: #a5a5a4;font-size: 10px;margin: 6px 0;overflow: hidden;padding: 3px 0;text-align: center;width: 100%;}.boxchat .boxc_content .vgc_report_spam{border-radius: 20px;color: #f00;cursor: pointer;display: inline;font-size: 11px;padding: 0 10px;}.vgc_update_info{ background-color: #4C8CF5; color: #fff; border-radius: 4px; display: inline-block; line-height: 18px; padding: 0 10px; cursor: pointer; text-shadow: none; margin-left: 10px;}.boxchat .boxc_content .rowfriend{text-align: left;}.boxchat .boxc_content .row{overflow: hidden;position: relative;padding: 3px 0;margin: 0 5px;}.boxchat .boxc_content .row img{max-width: 175px;}.boxchat .boxc_content .row p{display: block;margin: 2px 0;overflow: hidden;width: 100%;}.boxchat .boxc_content .row p>a{display: block;overflow: hidden;text-align: center;}.boxchat .boxc_content .row p span{border-top: 1px dashed #F4ACA6;color: #666666;display: block;font-weight: bold;line-height: 18px;overflow: hidden;padding-top: 5px;padding-left: 5px;padding-right: 3px;text-align: center;}.boxchat .boxc_content .row p img{margin-right: 5px;max-width: 183px;}.boxchat .boxc_content .row p b{color: #EA5246;display: block;margin-top: 5px;}.boxchat .boxc_content .row .icon_img{left: 0;position: absolute;top: 2px;width: 30px;}.boxchat .boxc_content .row .msgchat{border-radius: 5px;display: block;padding: 5px;box-shadow: 0 1px 0 #DCE0E6;line-height: 15px;max-width: 170px;position: relative;word-wrap: break-word;white-space: pre-wrap;}.boxchat .boxc_content .rowme .vgc_msg_time{color: #999;display: inline-block;float: right;font-size: 9px;line-height: 27px;padding-right: 3px;}.boxchat .boxc_content .rowfriend .vgc_msg_time{color: #999;display: inline-block;float: left;font-size: 9px;line-height: 27px;padding-left: 3px;}.boxchat .boxc_content .row .msgchat a{word-wrap: break-word;white-space: pre-wrap;color:green;}.boxchat .boxc_content .row .vgc_temmsg{opacity: 0.3;}.boxchat .boxc_content .row .msgchat font{word-wrap: break-word;white-space: pre-wrap;}.boxchat .boxc_content .rowme .msgchat{background-color: #D3E5FE;border: 1px solid #A3B6D0;float: right;color: #3E454C;margin-right: 6px;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);border-color: rgba(0, 0, 0, 0.18) rgba(0, 0, 0, 0.18) rgba(0, 0, 0, 0.29);}.boxchat .boxc_content .rowfriend .msgchat{background-color: #FBFBFB;border: 1px solid #C6C6C6;float: left;margin-left: 35px;border-color: rgba(0, 0, 0, 0.18) rgba(0, 0, 0, 0.18) rgba(0, 0, 0, 0.29);color: #3E454C;}.boxchat .boxc_content .row i{display: block;height: 12px;position: absolute;top: 5px;width: 8px;z-index: 12;}.boxchat .boxc_content .rowme i{background-color: #D3E5FE;background-position: -9px -212px;right: -8px;}.boxchat .boxc_content .rowfriend i{background-color: #FBFBFB;background-position: -1px -212px;left: -6px;}.vatgia_system_notice{background-color: #ffff99;border: 1px solid #a9a9b7;border-radius: 5px;color: #222;margin: 10px;overflow: hidden;padding: 5px 5px 0;}.vatgia_system_notice a{ display: block; text-align: center;color: #2E79BB !important;}.vatgia_system_notice a img{ display: block; margin: 0 auto 10px; max-width: 50%;}.vatgia_system_notice .vgc_vatgia_notice_top{display: block;margin: 0;overflow: hidden;}.vatgia_system_notice .vgc_vatgia_notice_top .vgc_vatgia_notice_time{color: #e53b35;float: right;font-family: arial;font-size: 11px;font-style: normal;margin-top: 5px;padding-right: 5px;}.vatgia_system_notice .vgc_vatgia_notice_top .vgc_vatgia_logo{background-image: url(data:image/png;base64,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);background-repeat: no-repeat;background-size: 110px auto;display: block;float: left;height: 27px;width: 110px;}.vatgia_system_notice .vgc_vatgia_notice_msg{margin: 5px 0;padding: 3px;}.vatgia_polls_system{border-radius: 5px;margin: 10px 5px;overflow: hidden; clear: both;}.vatgia_polls_system .vgc_polls_notice{box-sizing: content-box;margin: 0;padding: 0;}.vatgia_polls_system .vgc_polls_notice b{background-color: #3C9F45;color: #fff;padding: 3px 5px;display: inline-block;}.vatgia_polls_system .vgc_polls_notice .pollsmsg{background-color: #fff;border: 3px solid #3C9F45;color: #333;cursor: pointer;display: block;font-size: 12px;padding: 5px;}.vatgia_polls_system .vgc_polls_notice .pollstime{color: #999;font-size: 10px;font-style: normal;font-weight: normal;}.box_onlyname{background-color: #0C81F6;border: 1px solid #0C81F6;border-bottom: none;border-radius: 3px 3px 0 0;color: #333333;font-family: arial;font-size: 12px;font-weight: bold;height: 28px;line-height: 27px;cursor: pointer;position: relative;text-overflow: ellipsis;white-space: nowrap;}.box_onlyname:hover .boxc_ihn{display: block;}.box_onlyname.active{border: 1px solid #5D77B1;color: #fff;background-color: #5D77B1;}.box_onlyname span{display: block;margin-right: 15px;overflow: hidden;padding-left: 10px;text-overflow: ellipsis;white-space: nowrap;color: #fff;text-shadow: 0 1px 0 #1b5f8b;}.box_onlyname .boxc_ihn{background-position: 1px -94px;height: 14px;position: absolute;right: 3px;top: 6px;width: 13px;display:none;}@-webkit-keyframes myfirst{from {top: -10px;}to {top: -8px;}}@-moz-keyframes myfirst{from {top: -10px;}to {top: -8px;}}@-o-keyframes myfirst{from {top: -10px;}to {top: -8px;}}@-webkit-keyframes conline{from {top: 11px;}to {top: 5px;}}@-moz-keyframes conline{from {top: 11px;}to {top: 5px;}}@-o-keyframes conline{from {top: 11px;}to {top: 5px;}}@-webkit-keyframes coffline{from {top: 4px;}to {top: 3px;}}@-moz-keyframes coffline{from {top: 4px;}to {top: 3px;}}@-o-keyframes coffline{from {top: 4px;}to {top: 3px;}}@-webkit-keyframes contact{from {top: -2px;}to {top: 0px;}}@-moz-keyframes contact{from {top: -2px;}to {top: 0px;}}@-o-keyframes contact{from {top: -2px;}to {top: 0px;}}@-webkit-keyframes qColor{from {background-color: #0E76BC;}to {background-color: #FF8000;}}@-moz-keyframes qColor{from {background-color: #0E76BC;}to {background-color: #FF8000;}}@-o-keyframes qColor{from {background-color: #0E76BC;}to {background-color: #FF8000;}}@-webkit-keyframes qColor1{from {background-color: #F0F1F3;}to {background-color: #f00;}}@-moz-keyframes qColor1{from {background-color: #F0F1F3;}to {background-color: #f00;}}@-o-keyframes qColor1{from {background-color: #F0F1F3;}to {background-color: #f00;}}.box_onlyname .count_msg{animation: 0.5s ease 0s normal none infinite myfirst;-webkit-animation: 0.5s ease 0s normal none infinite myfirst;-moz-animation: 0.5s ease 0s normal none infinite myfirst;-o-animation: 0.5s ease 0s normal none infinite myfirst;background-color: #FF0000;border-radius: 3px;box-shadow: 0 0 1px #FFFFFF;color: #FFFFFF;font-size: 11px;font-style: normal;height: 15px;left: 0;line-height: 14px;padding: 0 4px;position: absolute;top: -8px;}#vgc_pn_conline{/*animation: 0.4s ease 0s normal none infinite conline;-webkit-animation: 0.4s ease 0s normal none infinite conline;-moz-animation: 0.4s ease 0s normal none infinite conline;-o-animation: 0.4s ease 0s normal none infinite conline;*/background-color: #f00;border-radius: 30px;color: #ffffff;font-family: arial;font-size: 12px;font-style: normal;font-weight: bold;height: 15px;line-height: 16px;padding: 0 4px;margin-left: 5px;top: 9px;text-shadow: none;}.box_onlyname .boxc_ihn:hover{background-position: 1px -107px;}#showboxchat .count_box_hide{background-color: #F0F1F3;border: 1px solid #BAC0CD;border-radius: 3px 3px 0 0;color: #333333;font-family: arial;font-size: 12px;font-weight: bold;height: 28px;left: -50px;line-height: 27px;padding: 0 6px 0 25px;position: absolute;border-bottom: none;cursor: pointer;z-index: 9999;}#showboxchat .count_box_hide.vgc_activemsg{animation: 5s ease 0s normal none infinite qColor1;-webkit-animation: 5s ease 0s normal none infinite qColor1;-moz-animation: 5s ease 0s normal none infinite qColor1;-o-animation:5s ease 0s normal none infinite qColor1;}#showboxchat .count_box_hide .icmsg{background-position: 0 1px;display: block;height: 18px;left: 5px;position: absolute;top: 5px;width: 20px;}#showboxchat .count_box_hide .name_hide{background-color: #FFFFFF;border-top: 1px solid #C2C2C5;bottom: 27px;box-shadow: 0 1px 1px #A3A3A5;max-width: 160px;min-width: 160px;padding: 3px 0;position: absolute;right: 0;z-index: 0;}#showboxchat .count_box_hide .name_hide .name{float: left;position: relative;width: 100%;}#showboxchat .count_box_hide .name_hide .subname{display: block;font-weight: normal;line-height: 22px;padding: 0 5px;position: relative;text-overflow: ellipsis;white-space: nowrap;overflow: hidden;margin-right: 30px;}#showboxchat .count_box_hide .name_hide .vgc_count_msgoff{background-color: #FF0000;border-radius: 3px;color: #FFFFFF;display: none;font-size: 11px;font-style: normal;height: 13px;line-height: 12px;padding: 0 3px;position: absolute;right: 16px;top: 4px;}#showboxchat .count_box_hide .name_hide .name .name_hide_icc{background-position: 0 -17px;height: 11px;position: absolute;right: 4px;top: 6px;width: 11px;}#showboxchat .count_box_hide .name_hide .name .name_hide_icc:hover{background-position: 0 -53px;}#showboxchat .count_box_hide .name_hide .name:hover{background-color: #2784C3;color: #fff;}#hide_panel_vgchat{background-color: #0C81F6;border: 1px solid #2C498F;border-radius: 5px 5px 0 0;text-shadow: 0 1px 0 #164E72;bottom: -1px;box-shadow: 0 0 1px #fff inset;height: 32px;line-height: 32px;padding: 0 30px 0 10px;position: fixed;right: 40px;z-index: 9999;border-bottom: none;font-weight: bold;cursor: pointer;min-width: 207px;max-width: 320px;white-space: nowrap;font-family: arial;font-size: 15px;color:#fff;}/*#hide_panel_vgchat .vgc_ic_pnicon{bottom: 24px;display: block;height: 44px;left: 20px;position: absolute;width: 188px;z-index: 2147483647;}*/#panel_chat_vatgia #vgc_help_pn{bottom: 34px;cursor: pointer;display: block;height: 141px;overflow: hidden;position: fixed;right: 5px;width: 200px;z-index: 9999999;}#panel_chat_vatgia #vgc_help_pn .vgc_hepl_icon{background: url("https://lh5.googleusercontent.com/-oMAatzaRbQE/U5bcANHMqhI/AAAAAAAAAB4/g__ofUHR148/w346-h244/help.png") repeat scroll 0 0 rgba(0, 0, 0, 0);cursor: pointer;display: block;height: 141px;width: 200px;}#panel_chat_vatgia #vgc_help_pn .vgc_closehelp{cursor: pointer;height: 20px;line-height: 20px;position: absolute;right: 0;text-align: center;top: 0;width: 20px;z-index: 999999;}#hide_panel_vgchat #vgc_help_pn:hover .vgc_closehelp{display: block !important;}#hide_panel_vgchat .ic_chat{background-position: -19px -226px;display: block;float: left;height: 23px;margin: 4px 5px 0 0;position: absolute;right: 0;width: 24px;}.messaging{color: #fff;background-color: #0C81F6;}.vgchat_hide{display: none;}.vgchat_over{overflow: hidden;}.vgc_fullscreen{background-position: -20px -14px;display: block;height: 15px;position: absolute;right: 25px;top: 10px;width: 20px;z-index: 5555;}#vgchat_ovlay_ct .vgc_fullscreen{background-position: -20px 1px;}#vgchat_ovlay{background-color: rgba(0, 0, 0, 0.6);height: 100%;left: 0;position: fixed;top: 0;width: 100%;z-index: 99999;}#boxchat_ivtestore{background-color: #FFFFFF;border: 10px solid #444444;border-radius: 5px;height: 460px;left: 100px;min-width: 350px;position: fixed;top: 100px;width: 350px;z-index: 999999;}#boxchat_ivtestore .close{background-color: #F0F0F0;border-radius: 0 0 0 10px;cursor: pointer;font-weight: bold;height: 20px;line-height: 20px;padding-left: 3px;position: absolute;right: 0;text-align: center;top: 0;width: 20px;}#vgchat_ovlay_ct{background-color: #FFFFFF;border: 10px solid #444444;border-radius: 5px;height: 492px;left: 100px;min-width: 500px;position: fixed;top: 100px;width: 600px;z-index: 999999;}#vgchat_ovlay_ct .boxchat{position: static !important;}#vgchat_ovlay_ct .boxc_content{height: 360px;max-height: 360px;}#vgchat_ovlay_ct .boxc_content .row .msgchat{max-width: 510px;}#vgchat_ovlay_ct .boxchat .boxc_h .boxchat_smsg{display: block !important;}#ivtEstore{list-style: none outside none;margin: 20px;padding: 0;font-family: arial;font-size: 13px;position: relative;}#ivtEstore li{overflow: hidden;padding: 5px 0;width: 100%;}#ivtEstore li .ivttextarea{border: 1px solid #DDDDDD;border-radius: 3px;font-family: arial;font-size: 13px;height: 80px;padding: 5px 2%;resize: none;width: 95%;}#ivtEstore li .ivttext{border: 1px solid #DDDDDD;border-radius: 3px;padding: 5px 2%;width: 95%;}#ivtEstore li .ivtbtn{background-color: #0E76BC;border: 1px solid #3855A9;border-radius: 3px;box-shadow: 0 2px 2px #DFF1FD;color: #FFFFFF;cursor: pointer;font-family: arial;font-weight: bold;padding: 5px;text-shadow: 0 1px 0 #3855A9;float: left;margin-right: 20px;}#ivtEstore li .ivtimage{border: 1px solid #CCCCCC;float: left;overflow: hidden;padding: 1px;width: 50px;}#ivtEstore li .ivtallinfo{margin-left: 60px;}#ivtEstore li .ivtallinfo h2{font-size: 14px;margin: 0 0 5px;max-height: 47px;overflow: hidden;}#ivtEstore li .ivtallinfo p{border: 1px solid #eeeeee;font-size: 11px;margin: 0;max-height: 45px;overflow-y: auto;padding: 0 5px;}#ivtEstore li .ivtallinfo span{color: #056DBA;display: inline;}#ivtEstore li .ivtallinfo select{background-color: #eeeeee;border: 1px solid #eeeeee;color: #444;font-family: arial;font-size: 10px;font-weight: bold;padding: 2px 0;width: 100%;}.ivthide{display: none;}.ivtloading{background-image: url(data:image/gif;base64,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);background-size: 30px 30px;}.vgc_common_loadding{background-image: url(data:image/gif;base64,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);}.ivtestoreload{width: 30px;height: 30px;float: left;}#polls_vgc{border-radius: 5px 5px 0 0;bottom: 0;box-shadow: 0 4px 5px rgba(0, 0, 0, 0.2);font-family: arial;font-size: 12px;overflow: hidden;position: fixed;right: 290px;max-width: 260px;z-index: 99999;}#polls_vgc .polls_header{background-color: #0C81F6;color: #FFFFFF;padding: 5px 60px 5px 10px;overflow: hidden;position: relative;}#polls_vgc .polls_header h3{color: #FFFFFF;font-size: 15px;line-height: 23px;margin: 0;text-shadow: 0 1px 0 #0A4E7A;cursor: pointer;white-space: nowrap;}#polls_vgc .polls_header #poll_mini{cursor: pointer;height: 13px;position: absolute;right: 30px;top: 11px;width: 20px;}#polls_vgc .polls_header .poll_minimize{background-position: -19px -55px;}#polls_vgc .polls_header .poll_maxnimize{background-position: -19px -44px;}#polls_vgc .polls_header .poll_close{background-position: -18px -67px;cursor: pointer;height: 17px;position: absolute;right: 5px;width: 16px;top: 7px;}#polls_vgc .polls_info{background-color: #FFFFFF;padding: 5px 0 0;display: none;border: 5px solid #2784c3;}#polls_vgc .polls_info h3{color: #0E76BC;font-size: 12px;margin: 5px 10px;}#polls_vgc table{list-style: none outside none;overflow: hidden;padding: 0px;}#polls_vgc table td{padding: 5px 0;}#polls_vgc .btn{background-color: #F9F9F9;overflow: hidden;padding: 0;position: relative;}#polls_vgc .ip{float: left;margin: 0 0 0 10px;}#polls_vgc table label{color: #444;display: block;font-family: arial;font-size: 13px;margin-left: 5px;overflow: hidden;}#polls_vgc .polls_btn{background-color: #0E76BC;border: none;border-radius: 3px;color: #FFFFFF;display: inline-block;font-size: 13px;margin: 0px 5px;padding: 5px 20px;text-shadow: 0 1px 0 #1F8BBA;cursor: pointer;}#polls_vgc .poll_load{background-image: url(data:image/gif;base64,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);display: inline-block;height: 20px;position: absolute;right: 78px;top: 15px;width: 20px;}#panel_chat_vatgia #vatgia_note_message{background-color: #0C81F6;border-radius: 3px;bottom: 30px;position: fixed;right: 40px;z-index: 9999999;}#panel_chat_vatgia #vatgia_note_message .vgc_msg_close{cursor: pointer;font-family: arial;font-size: 10px;padding: 0 5px;position: absolute;right: 0px;top: -13px;}#panel_chat_vatgia #vatgia_note_message #vatgia_note_content{color: #fff;cursor: pointer;display: block;font-size: 12px;padding: 5px 10px;text-shadow: 0 1px 0 #2170A5;font-family: arial;}#panel_chat_vatgia #vatgia_note_message #vatgia_note_content b{animation: 0.5s ease 0s normal none infinite contact;-webkit-animation: 0.5s ease 0s normal none infinite contact;-moz-animation: 0.5s ease 0s normal none infinite contact;-o-animation: 0.5s ease 0s normal none infinite contact;border-radius: 2px;background-color: #f00;position: relative;padding: 0 2px;margin: 0 2px;color: #fff;}#panel_chat_vatgia .vgc_chat_select{background-color: #fff;bottom: 0;box-sizing: content-box;display: block;padding: 0;position: absolute;text-align: center;width: 100%;}#panel_chat_vatgia .vgc_chat_select p{box-sizing: content-box;border-radius: 2px;color: #fff;cursor: pointer;font-size: 13px;font-weight: bold;line-height: 20px;}#panel_chat_vatgia .vgc_chat_select .vgc_htvg{position: relative;margin: 10px 0;}#panel_chat_vatgia .vgc_chat_select .vgc_c_vg{border: 1px solid #fff;box-sizing: border-box;color: #333;display: inline-block;font-size: 11px;text-align: center;margin: 0;width: 40%;}#panel_chat_vatgia .vgc_chat_select .vgc_c_vg:hover{border: 1px solid #0C81F6;}#panel_chat_vatgia .vgc_chat_select .vgc_c_vg img{border-radius: 100%;display: block;margin: 0 auto;max-width: 40px;overflow: hidden;width: 100%;}#panel_chat_vatgia .vgc_chat_select .vgc_c_ghonline{margin: 10px 40px;padding: 2px 10px;position: relative;}#panel_chat_vatgia .vgc_chat_select .vgc_c_ghonline{background-color: #ff7f00;text-shadow: 0 1px 0 #dd6f00;position: relative;margin: 10px;}#panel_chat_vatgia .vgc_chat_select p .vgc_cs_tooltip{background-color: #fff;border: 1px solid #ddd;border-radius: 3px;bottom: 65px;box-shadow: 0 0 3px #bbb;color: #444;display: none;font-size: 11px;font-weight: normal;padding: 5px;position: absolute;right: -30px;text-shadow: none;width: 220px;line-height: 16px;text-align: left;}#panel_chat_vatgia .vgc_chat_select .vgc_c_vg .vgc_cs_tooltip{left: 9px;}#panel_chat_vatgia .vgc_chat_select .vgc_c_ghonline .vgc_cs_tooltip:before{content: "";height: 10px;border: 0 0 10px 0 #ccc;position: absolute;border-top: 7px solid #ccc;border-bottom: 0;border-right: 7px solid transparent;border-left: 7px solid transparent;bottom: -17px;right: 50px;}#panel_chat_vatgia .vgc_chat_select .vgc_c_ghonline:hover .vgc_cs_tooltip{right: 0px;}#panel_chat_vatgia .vgc_chat_select .vgc_c_ghonline .vgc_cs_tooltip:after{content: "";height: 10px;border: 0 0 10px 0 #ccc;position: absolute;border-top: 7px solid #fff;border-bottom: 0;border-right: 5px solid transparent;border-left: 5px solid transparent;bottom: -17px;right: 52px;}#panel_chat_vatgia .vgc_chat_select p:hover .vgc_cs_tooltip{display: block;}#vgc_list_tags{background-color: #555555;border: 3px solid #fff;border-radius: 5px;bottom: 30px;box-shadow: 0 0 3px #000000;color: #fff;max-height: 200px;overflow-y: auto;padding: 5px 0;position: absolute;width: 230px;z-index: 9999;}#vgc_list_tags li{cursor: pointer;float: left;line-height: 20px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;width: 96%;padding: 0 2%;}#vgc_list_tags li:hover, #vgc_list_tags .vgc_sl_active{background-color: #333;}#vgc_list_tags li b{color: #fcd208;padding-right: 3px;font-weight: normal;}#vgc_list_tags li .vgc_short_tags{text-shadow: 0 1px 0 #000;}#vgc_list_tags li .vgc_text_tags{display: none;}#vgc_list_product{background-color: #fff;border: 3px solid #fff;border-radius: 5px;bottom: 30px;box-shadow: 0 0 3px #000000;color: #fff;max-height: 400px;overflow-y: auto;padding: 5px 0;position: fixed;width: 400px;z-index: 9999;bottom: 55px;}#vgc_list_product li{cursor: pointer;float: left;line-height: 20px;overflow: hidden;padding: 3px 2%;text-overflow: ellipsis;width: 96%;}#vgc_list_product li:nth-child(2n+1){background-color: #f6f6f6;}#vgc_list_product li .aimg{border: 1px solid #ccc;border-radius: 2px;float: left;height: 40px;margin-right: 5px;overflow: hidden;text-align: center;width: 50px;}#vgc_list_product li .aimg img{height: 100%;}#vgc_list_product li:hover, #vgc_list_product .vgc_sl_active{background-color: #C8E3F7 !important;}#vgc_list_product li b{color: #fcd208;padding-right: 3px;font-weight: normal;}#vgc_list_product li .vgc_short_tags{color: #222;display: block;font-size: 13px;line-height: 20px;}#vgc_list_product li .vgc_text_tags{display: none;}.vgc_get_notification_browser{ display: none; position: fixed; bottom: 40px; right: 40px; background-color: #FFFF80; border: 1px solid #FFFF00; border-radius: 3px; box-shadow: 0px 2px 4px #DDDD00; padding: 5px 30px 5px 10px; color: #222; font-weight: bold; cursor: pointer; font-family: arial; font-size: 12px; z-index: 99999999;}.vgc_get_notification_browser i{ position: absolute; top: 7px; right: 5px; font-style: normal; font-weight: normal; font-size: 11px; background-color: #D9D900; display: block; width: 12px; height: 12px; line-height: 10px; text-align: center; color: #fff; cursor: pointer; z-index: 2;}.vgc_get_notification_browser i:hover{ background-color: #222;}');
element_css_vgchat.setAttribute('type', 'text/css');
if(element_css_vgchat.styleSheet){// IE
	element_css_vgchat.styleSheet.cssText = style_content_vgchat.nodeValue;
} else {
	element_css_vgchat.appendChild(style_content_vgchat);
}
document.getElementsByTagName('head')[0].appendChild(element_css_vgchat);
delete element_css_vgchat;
delete style_content_vgchat;
var RealtimeDataConnect ="data=%7B%22channel%22%3A%5B-1%2C5609144%2C1283612941%5D%2C%22checksum%22%3A%22004480c9baa282de775449985098436a%22%2C%22check_id%22%3A%225f734d7dcba1a57510b90af451204df4%22%2C%22data%22%3A%22%22%7D&logged=1";var socket = io.connect("https://vc4.live.vnpgroup.net",{ query: RealtimeDataConnect });socket.on("connect", function () {iniLoadChatVatGia();$('#panel_chat_vatgia').append('<script>var vgc_list_support= new Array(0);</script><div class="box-user hide"><div class="vgc_panel_title_top"><span class="vgc_tt">Chat để được hỗ trợ </span><div class="other"><div title="Thiết lập" class="setting ic_chat"><div class="vgc_setting"><p>Cài đặt âm thanh: <i onClick="vgc_setting_sound();" class="vgc_iconsound vgc_s_on ic_chat"></i></p><p>Cài đặt thông báo: <i onClick="create_notification_browser();" class="vgc_iconnotifi vgc_n_on ic_chat"></i></p>     <p>Tắt tự động nhận chat: <i onclick="vgc_auto_show_boxchat();" class="vgc_iconautobox vgc_a_on ic_chat"></i></p></div></div><a onclick="hide_panel_vgchat()" title="Thu gọn" class="zoom ic_chat"></a></div></div><div class="vgc_panel_all"><ul id="VgChatListOnline" style="margin-bottom: 50px;"><input type="hidden" name="vgc_check_feed_online" id="vgc_check_feed_online" value="0" /><input type="hidden" name="vgc_send_id_pn" id="vgc_send_id_pn" value="5609144" /><audio id="vgc_audio_message" src="//live.vnpgroup.net/audio/notify.ogg" preload="none"></audio><h3 style="border-bottom: 1px solid #ddd;box-sizing: content-box; color: #666;font-size: 13px;line-height: 26px; margin: 0 5px;">Người chat gần đây</h3><li class=" friend_5609144" onclick="create_chat_box({id:5609144,iPro:0,send_id:5609144,msg:\'\',coffline:0,isshow : 1})"><span style="display: none;" class="for_id">5609144</span><img width="32" height="32" src=""><div class="pnrowid"><a class="name " href="javascript:;" title=""><span class="name " title="Trần Hưng"><i class="ic_chat ol"></i>Trần Hưng</span><div class="clear"></div></a></div><div class="tooltip hide"><span>Gửi lần cuối lúc: 07:00:00 01/01/1970</span></div></li></ul><div class="vgc_chat_select"> <div class="vgc_htvg"><p class="vgc_c_vg" onclick="create_chat_box({id:1515941,iPro:0,send_id:5609144})"><img src="//lh3.googleusercontent.com/rq-aNbMPTU6eLkUIw-JD7jHaPT_EoysXAoyCcZ-X4KpS-FWuiiew2reCIiKYL3k494LbBuCsSMGeXbeORzEDQ0eL3A=s512" />Hỗ trợ chung<span class="vgc_cs_tooltip">Chat với hỗ trợ chung để được giải đáp thắc mắc liên quan đến vatgia.com</span> </p><p class="vgc_c_vg" onclick="create_chat_box({id:3097368,iPro:0,send_id:5609144})"><img src="//lh3.googleusercontent.com/GQzMEmm2hOBkz63jjKdkQKnJ48wFFs2Xo27H4B5TSbFzEiK8g7rXnl2t53QkUlGK5fG6U9jTaZ678taccDn1omJP=s512" />Hỗ trợ quảng cáo<span class="vgc_cs_tooltip">Chat với hỗ trợ quảng cáo để được giải đáp thắc mắc về quảng cáo trên vatgia.com</span> </p></div></div></div><p class="vgc_logo_vchat"><a class="vgc_bt_logovchat vgc_logovchat" href="//vchat.vn/home/?utm_campaign=Box_chat_client&amp;utm_medium=referral&amp;utm_source=Box_chat_client" target="_blank"></a></p></div><div id="showboxchat"><div class="count_box_hide hide " onclick="show_name_hide(this);"><i class="ic_chat icmsg"></i><span class="counts"></span><div class="name_hide hide"></div></div></div><div id="hide_panel_vgchat" class="vgc_hide" onclick="hide_panel_vgchat();"><span class="vgc_ic_pnicon"></span><i class="ic_chat"></i>Chat để được hỗ trợ <b id="vgc_pn_conline">1</b><script>message_note_offline_slide();</script></div><div class="vgc_get_notification_browser" ><span onclick="create_notification_browser(this)">Đồng ý cho hiện thông báo khi có người chat đến</span> <i onclick="vgc_close_get_notification(this);">x</i></div>');});