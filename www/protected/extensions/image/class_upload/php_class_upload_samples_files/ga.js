(function(){var k=void 0,aa=encodeURIComponent,l=String,o=Math,ba="push",ca="cookie",p="charAt",q="indexOf",da="getTime",r="toString",s="window",v="length",w="document",x="split",y="location",ea="protocol",z="href",A="substring",C="join",D="toLowerCase";var fa="_gat",ga="_gaq",ha="4.9.1",ia="_gaUserPrefs",ja="ioo",E="&",F="=",H="__utma=",ka="__utmb=",la="__utmc=",ma="__utmk=",I="__utmv=",J="__utmz=",na="__utmx=",oa="GASO=";var pa=function(){var d=this,f=[],b="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_";d.set=function(b){f[b]=!0};d.Sc=function(){for(var d=[],e=0;e<f[v];e++)f[e]&&(d[o.floor(e/6)]^=1<<e%6);for(e=0;e<d[v];e++)d[e]=b[p](d[e]||0);return d[C]("")+"~"}},qa=new pa;function K(d){qa.set(d)};var ra=function(d,f){var b=this;b.window=d;b.document=f;b.setTimeout=function(b,e){setTimeout(b,e)};b.Jb=function(b){return navigator.userAgent[q](b)>=0};b.Xc=function(){return b.Jb("Firefox")&&![].reduce};b.Vc=function(){return L[s][ia]};b.Gc=function(){return L[s].external};b.Hc=function(){return L[s].performance||L[s].webkitPerformance};b.Ic=function(){return L[s].top==L[s]};b.Ya=function(b){var e=L[s]&&L[s].gaGlobal;if(b&&!e)e={},L[s].gaGlobal=e;return e};b.ec=function(b){L[w][y].href=b};b.qb=
function(d){if(!d||!b.Jb("Firefox"))return d;for(var d=d.replace(/\n|\r/g," "),e=0,f=d[v];e<f;++e){var g=d.charCodeAt(e)&255;if(g==10||g==13)d=d[A](0,e)+"?"+d[A](e+1)}return d}},L=new ra(window,document);var sa=function(d){return function(f,b,h){d[f]=function(){K(b);return h.apply(d,arguments)};return h}},ta=function(d,f,b,h){d.addEventListener?d.addEventListener(f,b,!!h):d.attachEvent&&d.attachEvent("on"+f,b)},ua=function(d){return Object.prototype[r].call(Object(d))=="[object Array]"},M=function(d){return k==d||"-"==d||""==d},N=function(d,f,b){var h="-",e;!M(d)&&!M(f)&&!M(b)&&(e=d[q](f),e>-1&&(b=d[q](b,e),b<0&&(b=d[v]),h=d[A](e+f[q](F)+1,b)));return h},xa=function(d){var f=!1,b=0,h,e;if(!M(d)){f=
!0;for(h=0;h<d[v];h++)e=d[p](h),b+="."==e?1:0,f=f&&b<=1&&(0==h&&"-"==e||".0123456789"[q](e)>-1)}return f},P=function(d,f){var b=aa;return b instanceof Function?f?encodeURI(d):b(d):(K(68),escape(d))},Q=function(d,f){var b=decodeURIComponent,h,d=d[x]("+")[C](" ");if(b instanceof Function)try{h=f?decodeURI(d):b(d)}catch(e){K(17),h=unescape(d)}else K(68),h=unescape(d);return h},R=function(d,f){return d[q](f)>-1};
function ya(d){if(!d||""==d)return"";for(;d[p](0)[v]>0&&" \n\r\t"[q](d[p](0))>-1;)d=d[A](1);for(;d[p](d[v]-1)[v]>0&&" \n\r\t"[q](d[p](d[v]-1))>-1;)d=d[A](0,d[v]-1);return d}var T=function(d,f){d[ba]||K(94);d[d[v]]=f},za=function(d){var f=1,b=0,h;if(!M(d)){f=0;for(h=d[v]-1;h>=0;h--)b=d.charCodeAt(h),f=(f<<6&268435455)+b+(b<<14),b=f&266338304,f=b!=0?f^b>>21:f}return f},Aa=function(){return o.round(o.random()*2147483647)},Ba=function(){};var Ca=function(d,f){this.ib=d;this.jb=f},Da=function(){function d(b){for(var d=[],b=b[x](","),e,f=0;f<b[v];f++)e=b[f][x](":"),d[ba](new Ca(e[0],e[1]));return d}var f=this;f.Ca="utm_campaign";f.Da="utm_content";f.Ea="utm_id";f.Fa="utm_medium";f.Ga="utm_nooverride";f.Ha="utm_source";f.Ia="utm_term";f.Ja="gclid";f.vc="dclid";f.V=0;f.B=0;f.La=15768E6;f.Ma=18E5;f.s=63072E6;f.W=[];f.X=[];f.wc="cse";f.xc="q";f.Ta=50;f.J=d("daum:q,eniro:search_word,naver:query,pchome:q,images.google:q,google:q,yahoo:p,yahoo:q,msn:q,bing:q,aol:query,aol:encquery,aol:q,lycos:query,ask:q,altavista:q,netscape:query,cnn:query,about:terms,mamma:q,alltheweb:q,voila:rdata,virgilio:qs,live:q,baidu:wd,alice:qs,yandex:text,najdi:q,mama:query,seznam:q,search:q,wp:szukaj,onet:qt,szukacz:q,yam:k,kvasir:q,sesam:q,ozu:q,terra:query,mynet:q,ekolay:q,rambler:query,rambler:words");
f.f="/";f.L=100;f.ha="/__utm.gif";f.ma=1;f.na=1;f.w="|";f.la=1;f.Ka=1;f.Ua=1;f.c="auto";f.D=1;f.Wb=10;f.zc=10;f.Ac=0.2;f.p=k};var Ea=function(d){function f(a,c,b,j){var i="",d=0,i=N(a,"2"+c,";");if(!M(i)){a=i[q]("^"+b+".");if(a<0)return["",0];i=i[A](a+b[v]+2);i[q]("^")>0&&(i=i[x]("^")[0]);b=i[x](":");i=b[1];d=parseInt(b[0],10);!j&&d<e.n&&(i="")}M(i)&&(i="");return[i,d]}function b(a,c){return"^"+[[c,a[1]][C]("."),a[0]][C](":")}function h(a){var c=new Date,a=new Date(c[da]()+a);return"expires="+a.toGMTString()+"; "}var e=this,m=d;e.n=(new Date)[da]();var g=[H,ka,la,J,I,na,oa];e.g=function(){var a=L[w][ca];return m.p?e.Nc(a,
m.p):a};e.Nc=function(a,c){for(var b=[],j,i=0;i<g[v];i++)j=f(a,g[i],c)[0],M(j)||(b[b[v]]=g[i]+j+";");return b[C]("")};e.m=function(a,c,b){var j=b>0?h(b):"";m.p&&(c=e.Oc(L[w][ca],a,m.p,c,b),a="2"+a,j=b>0?h(m.s):"");a+=c;a=L.qb(a);a[v]>2E3&&(K(69),a=a[A](0,2E3));j=a+"; path="+m.f+"; "+j+e.hb();if(!V.pb())L[w].cookie=j};e.Oc=function(a,c,d,j,i){var g="",i=i||m.s,j=b([j,e.n+i*1],d),g=N(a,"2"+c,";");return!M(g)?(a=b(f(a,c,d,!0),d),g=g[x](a)[C](""),g=j+g):j};e.hb=function(){return M(m.c)?"":"domain="+m.c+
";"}};var Fa=function(d){function f(a){a=ua(a)?a[C]("."):"";return M(a)?"-":a}function b(a,c){var n=[],b;if(!M(a)&&(n=a[x]("."),c))for(b=0;b<n[v];b++)xa(n[b])||(n[b]="-");return n}function h(a,c,n){var b=i.I,j,d;for(j=0;j<b[v];j++)d=b[j][0],d+=M(c)?c:c+b[j][4],b[j][2](N(a,d,n))}var e,m,g,a,c,t,j,i=this,u,n=d;i.i=new Ea(d);i.Ba=function(){return k==u||u==i.K()};i.g=function(){return i.i.g()};i.fa=function(){return c?c:"-"};i.Pa=function(a){c=a};i.ga=function(a){u=xa(a)?a*1:"-"};i.ea=function(){return f(t)};
i.Y=function(a){t=b(a)};i.yc=function(){i.i.m(I,"",-1)};i.Rb=function(){return u?u:"-"};i.hb=function(){return M(n.c)?"":"domain="+n.c+";"};i.ca=function(){return f(e)};i.Na=function(a){e=b(a,1)};i.C=function(){return f(m)};i.aa=function(a){m=b(a,1)};i.da=function(){return f(g)};i.Oa=function(a){g=b(a,1)};i.qa=function(){return f(a)};i.ra=function(c){a=b(c);for(c=0;c<a[v];c++)c<4&&!xa(a[c])&&(a[c]="-")};i.Fc=function(){return j};i.Dc=function(a){j=a};i.Qb=function(){e=[];m=[];g=[];a=[];c=k;t=[];u=
k};i.K=function(){for(var a="",c=0;c<i.I[v];c++)a+=i.I[c][1]();return za(a)};i.$=function(a){var c=i.g(),n=!1;c&&(h(c,a,";"),i.ga(l(i.K())),n=!0);return n};i.Sb=function(a){h(a,"",E);i.ga(N(a,ma,E))};i.Tb=function(){var a=i.I,c=[],n;for(n=0;n<a[v];n++)T(c,a[n][0]+a[n][1]());T(c,ma+i.K());return c[C](E)};i.Ub=function(a,c){var b=i.I,j=n.f;i.$(a);n.f=c;for(var d=0;d<b[v];d++)if(!M(b[d][1]()))b[d][3]();n.f=j};i.Qa=function(){i.i.m(H,i.ca(),n.s)};i.ba=function(){i.i.m(ka,i.C(),n.Ma)};i.Ra=function(){i.i.m(la,
i.da(),0)};i.sa=function(){i.i.m(J,i.qa(),n.La)};i.Sa=function(){i.i.m(na,i.fa(),n.s)};i.Z=function(){i.i.m(I,i.ea(),n.s)};i.Ec=function(){i.i.m(oa,i.Fc(),0)};i.I=[[H,i.ca,i.Na,i.Qa,"."],[ka,i.C,i.aa,i.ba,""],[la,i.da,i.Oa,i.Ra,""],[na,i.fa,i.Pa,i.Sa,""],[J,i.qa,i.ra,i.sa,"."],[I,i.ea,i.Y,i.Z,"."]]};var Ga="https:"==L[w][y][ea]?"https://ssl.google-analytics.com/":"http://www.google-analytics.com/",Ha=Ga+"p/__utm.gif",Ja=function(){var d=this;d.Bb=function(f,b,h,e,m){b[v]<=2036||m?d.Aa(f+"?"+b,e):b[v]<=8192?L.Xc()?d.Aa(f+"?"+h+"&err=ff2post&len="+b[v],e):d.fd(b,e):d.Aa(f+"?"+h+"&err=len&max=8192&len="+b[v],e)};d.Aa=function(d,b){var h=new Image(1,1);h.src=d;h.onload=function(){h.onload=null;(b||Ba)()}};d.fd=function(f,b){d.ed(f,b)||d.Ob(f,b)};d.ed=function(d,b){var h,e=L[s].XDomainRequest;if(e)h=
new e,h.open("POST",Ha);else if(e=L[s].XMLHttpRequest)e=new e,"withCredentials"in e&&(h=e,h.open("POST",Ha,!0),h.setRequestHeader("Content-Type","text/plain"));return h?(h.onreadystatechange=function(){h.readyState==4&&(b&&b(),h=null)},h.send(d),!0):!1};d.Ob=function(f,b){var h=L[w];if(h.body){f=aa(f);try{var e=h.createElement('<iframe name="'+f+'"></iframe>')}catch(m){e=h.createElement("iframe"),e.name=f}e.height="0";e.width="0";e.style.display="none";e.style.visibility="hidden";var g=h[y],g=g[ea]+
"//"+g.host+"/favicon.ico",g=Ga+"u/post_iframe.html#"+aa(g),a=function(){e.src="";e.parentNode&&e.parentNode.removeChild(e)};ta(L[s],"beforeunload",a);var c=!1,t=0,j=function(){if(!c){try{if(t>9||e.contentWindow[y].host==h[y].host){c=!0;a();var d=L[s],g="beforeunload",n=a;d.removeEventListener?d.removeEventListener(g,n,!1):d.detachEvent&&d.detachEvent("on"+g,n);b&&b();return}}catch(f){}t++;L.setTimeout(j,200)}};ta(e,"load",j);h.body.appendChild(e);e.src=g}else L.setTimeout(function(){d.Ob(f,b)},100)}};var Ka=function(d){var f=this,b=d,h=new Fa(b),e=null,m=!V.pb(),g=function(){};f.Uc=function(){return"https:"==L[w][y][ea]?"https://ssl.google-analytics.com/__utm.gif":"http://www.google-analytics.com/__utm.gif"};f.u=function(a,c,d,j,i,u){e||(e=new Ja);var n=b.D,O=L[w][y];h.$(d);var B=h.C()[x](".");if(B[1]<500||j){if(i){var S=(new Date)[da](),X;X=(S-B[3])*(b.Ac/1E3);X>=1&&(B[2]=o.min(o.floor(B[2]*1+X),b.zc),B[3]=S)}if(j||!i||B[2]>=1){!j&&i&&(B[2]=B[2]*1-1);j=B[1]*1+1;B[1]=j;i="utmwv="+ha;S="&utms="+
j;X="&utmn="+Aa();j=i+"e"+S+X;a=i+S+X+(M(O.hostname)?"":"&utmhn="+P(O.hostname))+(b.L==100?"":"&utmsp="+P(b.L))+a;if(0==n||2==n)O=2==n?g:u||g,m&&e.Bb(b.ha,a,j,O,!0);if(1==n||2==n)c="&utmac="+c,j+=c,a+=c+"&utmcc="+f.Tc(d),V.wb&&(d="&aip=2",j+=d,a+=d),a+="&utmu="+qa.Sc(),m&&e.Bb(f.Uc(),a,j,u)}}h.aa(B[C]("."));h.ba()};f.Tc=function(a){for(var c=[],b=[H,J,I,na],d=h.g(),i,g=0;g<b[v];g++)if(i=N(d,b[g]+a,";"),!M(i)){if(b[g]==I){i=i[x](a+".")[1][x]("|")[0];if(M(i))continue;i=a+"."+i}T(c,b[g]+i+";")}return P(c[C]("+"))}};var W=function(){var d=this;d.N=[];d.Va=function(f){for(var b,h=d.N,e=0;e<h[v];e++)b=f==h[e].q?h[e]:b;return b};d.Xb=function(f,b,h,e,m,g,a,c){var t=d.Va(f);k==t?(t=new W.Wc(f,b,h,e,m,g,a,c),T(d.N,t)):(t.tb=b,t.Ab=h,t.zb=e,t.xb=m,t.ub=g,t.yb=a,t.vb=c);return t}};W.Qc=function(d,f,b,h,e,m){var g=this;g.Fb=d;g.va=f;g.o=b;g.Cb=h;g.Db=e;g.Eb=m;g.ia=function(){return"&"+["utmt=item","tid="+P(g.Fb),"ipc="+P(g.va),"ipn="+P(g.o),"iva="+P(g.Cb),"ipr="+P(g.Db),"iqt="+P(g.Eb)][C]("&utm")}};
W.Wc=function(d,f,b,h,e,m,g,a){var c=this;c.q=d;c.tb=f;c.Ab=b;c.zb=h;c.xb=e;c.ub=m;c.yb=g;c.vb=a;c.M=[];c.Vb=function(a,b,d,g,n){var e=c.Rc(a),f=c.q;k==e?T(c.M,new W.Qc(f,a,b,d,g,n)):(e.Fb=f,e.va=a,e.o=b,e.Cb=d,e.Db=g,e.Eb=n)};c.Rc=function(a){for(var b,d=c.M,g=0;g<d[v];g++)b=a==d[g].va?d[g]:b;return b};c.ia=function(){return"&"+["utmt=tran","id="+P(c.q),"st="+P(c.tb),"to="+P(c.Ab),"tx="+P(c.zb),"sp="+P(c.xb),"ci="+P(c.ub),"rg="+P(c.yb),"co="+P(c.vb)][C]("&utmt")}};var La=function(d){function f(){var b,a,c;a="ShockwaveFlash";var d="$version",j=L[s].navigator;if((j=j?j.plugins:k)&&j[v]>0)for(b=0;b<j[v]&&!c;b++)a=j[b],R(a.name,"Shockwave Flash")&&(c=a.description[x]("Shockwave Flash ")[1]);else{a=a+"."+a;try{b=new ActiveXObject(a+".7"),c=b.GetVariable(d)}catch(e){}if(!c)try{b=new ActiveXObject(a+".6"),c="WIN 6,0,21,0",b.xe="always",c=b.GetVariable(d)}catch(f){}if(!c)try{b=new ActiveXObject(a),c=b.GetVariable(d)}catch(n){}c&&(c=c[x](" ")[1][x](","),c=c[0]+"."+
c[1]+" r"+c[2])}return c?c:h}var b=this,h="-",e=L[s].screen,m=L[s].navigator;b.Nb=e?e.width+"x"+e.height:h;b.Mb=e?e.colorDepth+"-bit":h;b.cd=P(L[w].characterSet?L[w].characterSet:L[w].charset?L[w].charset:h);b.Lb=(m&&m.language?m.language:m&&m.browserLanguage?m.browserLanguage:h)[D]();b.Kb=m&&m.javaEnabled()?1:0;b.dd=d?f():h;b.dc=function(){return E+"utm"+["cs="+P(b.cd),"sr="+b.Nb,"sc="+b.Mb,"ul="+b.Lb,"je="+b.Kb,"fl="+P(b.dd)][C]("&utm")};b.cc=function(){for(var d=L[s].navigator,a=L[s].history[v],
d=d.appName+d.version+b.Lb+d.platform+d.userAgent+b.Kb+b.Nb+b.Mb+(L[w][ca]?L[w][ca]:"")+(L[w].referrer?L[w].referrer:""),c=d[v];a>0;)d+=a--^c++;return za(d)}};var Z=function(d,f,b,h){function e(a){var c="",c=a[x]("://")[1][D]();R(c,"/")&&(c=c[x]("/")[0]);return c}var m=h,g=this;g.a=d;g.ob=f;g.n=b;g.mb=function(a){var c=g.ua();return new Z.A(N(a,m.Ea+F,E),N(a,m.Ha+F,E),N(a,m.Ja+F,E),g.S(a,m.Ca,"(not set)"),g.S(a,m.Fa,"(not set)"),g.S(a,m.Ia,c&&!M(c.G)?Q(c.G):k),g.S(a,m.Da,k),N(a,m.vc+F,E))};g.nb=function(a){var c=e(a),b;b=a;var d="";b=b[x]("://")[1][D]();R(b,"/")&&(b=b[x]("/")[1],R(b,"?")&&(d=b[x]("?")[0]));b=d;return R(c,"google")&&(a=a[x]("?")[C](E),R(a,
E+m.xc+F)&&b==m.wc)?!0:!1};g.ua=function(){var a,c=g.ob,b,d=m.J;if(!M(c)&&"0"!=c&&R(c,"://")&&!g.nb(c)){a=e(c);for(var i=0;i<d[v];i++)if(b=d[i],R(a,b.ib[D]())&&(c=c[x]("?")[C](E),R(c,E+b.jb+F)))return a=c[x](E+b.jb+F)[1],R(a,E)&&(a=a[x](E)[0]),new Z.A(k,b.ib,k,"(organic)","organic",a,k,k)}};g.S=function(a,c,b){a=N(a,c+F,E);return b=!M(a)?Q(a):!M(b)?b:"-"};g.Bc=function(a){var c=m.W,b=!1;if(a&&"organic"==a.Q)for(var a=Q(a.G)[D](),d=0;d<c[v];d++)b=b||c[d][D]()==a;return b};g.lb=function(){var a="",
c="",a=g.ob;if(!M(a)&&"0"!=a&&R(a,"://")&&!g.nb(a))return a=a[x]("://")[1],R(a,"/")&&(c=a[A](a[q]("/")),c=c[x]("?")[0],a=a[x]("/")[0][D]()),0==a[q]("www.")&&(a=a[A](4)),new Z.A(k,a,k,"(referral)","referral",k,c,k)};g.kb=function(a){var c="";m.V&&(c=a&&a.hash?a[z][A](a[z][q]("#")):"",c=""!=c?c+E:c);c+=a.search;return c};g.ta=function(){return new Z.A(k,"(direct)",k,"(direct)","(none)",k,k,k)};g.Cc=function(a){var c=!1,b=m.X;if(a&&"referral"==a.Q)for(var a=P(a.R)[D](),d=0;d<b[v];d++)c=c||R(a,b[d][D]());
return c};g.h=function(a){return k!=a&&a.fb()};g.ue=function(a){var a=N(a,J+g.a+".",";"),c=a[x]("."),a=new Z.A;a.gb(c.slice(4)[C]("."));if(!g.h(a))return!0;c=L[w][y];c=g.kb(c);c=g.mb(c);g.h(c)||(c=g.ua(),g.h(c)||(c=g.lb()));return g.h(c)&&a.H()[D]()!=c.H()[D]()};g.Pb=function(a,c){if(m.Ka){var b="",d="-",e,f=0,n,h,B=g.a;if(a){h=a.g();b=g.kb(L[w][y]);if(m.B&&a.Ba()&&(d=Q(a.qa()),!M(d)&&!R(d,";"))){a.ra(d);a.sa();return}d=N(h,J+B+".",";");e=g.mb(b);if(g.h(e)&&(b=N(b,m.Ga+F,E),"1"==b&&!M(d)))return;
if(!g.h(e)){e=g.ua();b=g.Bc(e);if(!M(d)&&b)return;b&&(e=g.ta())}if(!g.h(e)&&c){e=g.lb();b=g.Cc(e);if(!M(d)&&b)return;b&&(e=g.ta())}g.h(e)||M(d)&&c&&(e=g.ta());if(g.h(e)&&(M(d)||(f=d[x]("."),n=new Z.A,n.gb(f.slice(4)[C](".")),n=n.H()[D]()==e.H()[D](),f=f[3]*1),!n||c))h=N(h,H+B+".",";"),n=h.lastIndexOf("."),h=n>9?h[A](n+1)*1:0,f++,h=0==h?1:h,a.ra([B,g.n,h,f,e.H()][C](".")),a.sa()}}}};
Z.A=function(d,f,b,h,e,m,g,a){var c=this;c.q=d;c.R=f;c.ya=b;c.o=h;c.Q=e;c.G=m;c.Gb=g;c.xa=a;c.H=function(){var a=[],b=[["cid",c.q],["csr",c.R],["gclid",c.ya],["ccn",c.o],["cmd",c.Q],["ctr",c.G],["cct",c.Gb],["dclid",c.xa]],d,e;if(c.fb())for(d=0;d<b[v];d++)M(b[d][1])||(e=b[d][1][x]("+")[C]("%20"),e=e[x](" ")[C]("%20"),T(a,"utm"+b[d][0]+F+e));return L.qb(a[C]("|"))};c.fb=function(){return!(M(c.q)&&M(c.R)&&M(c.ya)&&M(c.xa))};c.gb=function(a){var b=function(b){return Q(N(a,"utm"+b+F,"|"))};c.q=b("cid");
c.R=b("csr");c.ya=b("gclid");c.o=b("ccn");c.Q=b("cmd");c.G=b("ctr");c.Gb=b("cct");c.xa=b("dclid")}};var Ma=function(d,f,b,h){var e=this,m=f,g=F,a=d,c=h;e.T=b;e.wa="";e.r={};e.$b=function(){var a;a=N(e.T.g(),I+m+".",";")[x](m+".")[1];if(!M(a)){a=a[x]("|");var b=e.r,c=a[1],d;if(!M(c))for(var c=c[x](","),n=0;n<c[v];n++)d=c[n],M(d)||(d=d[x](g),d[v]==4&&(b[d[0]]=[Q(d[1]),Q(d[2]),1]));e.wa=Q(a[0]);e.U()}};e.U=function(){e.Pc();var a=P(e.wa),b,c,d="";for(b in e.r)(c=e.r[b])&&1===c[2]&&(d+=b+g+P(c[0])+g+P(c[1])+g+1+",");M(d)||(a+="|"+d);M(a)?e.T.yc():(e.T.Y(m+"."+a),e.T.Z())};e.bc=function(a){e.wa=a;e.U()};
e.ac=function(c,b,d,g){1!=g&&2!=g&&3!=g&&(g=3);var n=!1;if(b&&d&&c>0&&c<=a.Ta){var f=P(b),h=P(d);f[v]+h[v]<=64&&(e.r[c]=[b,d,g],e.U(),n=!0)}return n};e.Zb=function(a){if((a=e.r[a])&&1===a[2])return a[1]};e.Yb=function(a){var c=e.r;c[a]&&(delete c[a],e.U())};e.Pc=function(){c.t(8);c.t(9);c.t(11);var a=e.r,b,d;for(d in a)if(b=a[d])c.j(8,d,b[0]),c.j(9,d,b[1]),(b=b[2])&&3!=b&&c.j(11,d,""+b)}};var Na=function(){function d(a,b,c,d){k==g[a]&&(g[a]={});k==g[a][b]&&(g[a][b]=[]);g[a][b][c]=d}function f(a,b,c){if(k!=g[a]&&k!=g[a][b])return g[a][b][c]}function b(a,b){if(k!=g[a]&&k!=g[a][b]){g[a][b]=k;var c=!0,d;for(d=0;d<t[v];d++)if(k!=g[a][t[d]]){c=!1;break}c&&(g[a]=k)}}function h(a){var b="",c=!1,d,e;for(d=0;d<t[v];d++)if(e=a[t[d]],k!=e){c&&(b+=t[d]);for(var c=[],g=k,f=k,f=0;f<e[v];f++)if(k!=e[f]){g="";f!=S&&k==e[f-1]&&(g+=f[r]()+n);var h;h=e[f];for(var O="",m=k,U=k,wa=k,m=0;m<h[v];m++)U=h[p](m),
wa=B[U],O+=k!=wa?wa:U;h=O;g+=h;T(c,g)}e=j+c[C](u)+i;b+=e;c=!1}else c=!0;return b}var e=this,m=sa(e),g={},a="k",c="v",t=[a,c],j="(",i=")",u="*",n="!",O="'",B={};B[O]="'0";B[i]="'2";B[u]="'2";B[n]="'2";var S=1;e.Yc=function(a){return k!=g[a]};e.v=function(){var a="",b;for(b in g)k!=g[b]&&(a+=b[r]()+h(g[b]));return a};e.hc=function(a){if(a==k)return e.v();var b=a.v(),c;for(c in g)k!=g[c]&&!a.Yc(c)&&(b+=c[r]()+h(g[c]));return b};e.j=m("_setKey",89,function(b,c,n){if(typeof n!="string")return!1;d(b,a,
c,n);return!0});e.ka=m("_setValue",90,function(a,b,n){if(typeof n!="number"&&(k==Number||!(n instanceof Number))||o.round(n)!=n||n==NaN||n==Infinity)return!1;d(a,c,b,n[r]());return!0});e.fc=m("_getKey",87,function(b,c){return f(b,a,c)});e.gc=m("_getValue",88,function(a,b){return f(a,c,b)});e.t=m("_clearKey",85,function(c){b(c,a)});e.ja=m("_clearValue",86,function(a){b(a,c)})};var Oa=function(d,f){var b=this,h=sa(b);b.Ae=f;b.gd=d;b.Za=h("_trackEvent",91,function(d,h,g){return f.Za(b.gd,d,h,g)})};var Pa=function(d,f){var b=this,h=L.Gc(),e=L.Hc(),m=10;b.rb=new Na;b.Kc=function(){var b,a="timing",c="onloadT";h&&h[c]!=k&&h.isValidLoadTime?b=h[c]:e&&e[a]&&(b=e[a].loadEventStart-e[a].fetchStart);return b};b.Mc=function(){return d.z()&&d.Xa()%100<m};b.Lc=function(){var e="&utmt=event&utme="+P(b.rb.v())+d.O();f.u(e,d.k,d.a,!1,!0)};b.Jc=function(b){b=o.min(o.floor(b/100),5E3);return b>0?b+"00":"0"};b.sb=function(){var d=b.Kc();if(d==k||isNaN(d))return!1;if(d<=0)return!0;if(d>2147483648)return!1;var a=
b.rb;a.t(14);a.ja(14);var c=b.Jc(d);a.j(14,1,c)&&a.ka(14,1,d)&&b.Lc();h&&h.isValidLoadTime!=k&&h.setPageReadyTime();return!1};b.Wa=function(){if(!b.Mc())return!1;if(!L.Ic())return!1;b.sb()&&ta(L[s],"load",b.sb,!1);return!0}};var $=function(){};$.Zc=function(d){var f="gaso=",b=L[w][y].hash;d=b&&1==b[q](f)?N(b,f,E):(b=L[s].name)&&0<=b[q](f)?N(b,f,E):N(d.g(),oa,";");return d};$.ad=function(d,f){var b=(f||"www")+".google.com",b="https://"+b+"/analytics/reporting/overlay_js?gaso="+d+E+Aa(),h="_gasojs",e=L[w].createElement("script");e.type="text/javascript";e.src=b;if(h)e.id=h;(L[w].getElementsByTagName("head")[0]||L[w].getElementsByTagName("body")[0]).appendChild(e)};
$.load=function(d,f){if(!$.$c){var b=$.Zc(f),h=b&&b.match(/^(?:\|([-0-9a-z.]{1,30})\|)?([-.\w]{10,1200})$/i);if(h)f.Dc(b),f.Ec(),V._gasoDomain=d.c,V._gasoCPath=d.f,$.ad(h[2],h[1]);$.$c=!0}};var Qa=function(d,f,b){function h(){if("auto"==j.c){var a=L[w].domain;"www."==a[A](0,4)&&(a=a[A](4));j.c=a}j.c=j.c[D]()}function e(){h();var a=j.c,b=a[q]("www.google.")*a[q](".google.")*a[q]("google.");return b||"/"!=j.f||a[q]("google.org")>-1}function m(b,c,d){if(M(b)||M(c)||M(d))return"-";b=N(b,H+a.a+".",c);M(b)||(b=b[x]("."),b[5]=""+(b[5]?b[5]*1+1:1),b[3]=b[4],b[4]=d,b=b[C]("."));return b}function g(){return"file:"!=L[w][y][ea]&&e()}var a=this,c=sa(a),t=k,j=new Da,i=!1,u=k;a.o=d;a.n=o.round((new Date)[da]()/
1E3);a.k=f||"UA-XXXXX-X";a.ab=L[w].referrer;a.oa=k;a.e=k;a.F=!1;a.P=k;a.d=k;a.bb=k;a.pa=k;a.a=k;a.l=k;j.p=b?P(b):k;a.eb=!1;a.mc=function(){return Aa()^a.P.cc()&2147483647};a.lc=function(){if(!j.c||""==j.c||"none"==j.c)return j.c="",1;h();return j.Ua?za(j.c):1};a.kc=function(a,b){if(M(a))a="-";else{b+=j.f&&"/"!=j.f?j.f:"";var c=a[q](b),a=c>=0&&c<=8?"0":"["==a[p](0)&&"]"==a[p](a[v]-1)?"-":a}return a};a.O=function(b){var c="";c+=j.la?a.P.dc():"";c+=j.ma&&!M(L[w].title)?"&utmdt="+P(L[w].title):"";var d;
d=L.Ya(!0);if(!d.hid)d.hid=Aa();d=d.hid;c+="&utmhid="+d+"&utmr="+P(l(a.oa))+"&utmp="+P(a.pc(b));return c};a.pc=function(a){var b=L[w][y];a&&K(13);return a=k!=a&&""!=a?P(a,!0):P(b.pathname+b.search,!0)};a.uc=function(b){if(a.z()){var c="";a.d!=k&&a.d.v()[v]>0&&(c+="&utme="+P(a.d.v()));c+=a.O(b);t.u(c,a.k,a.a)}};a.jc=function(){var b=new Fa(j);return b.$(a.a)?b.Tb():k};a.cb=c("_getLinkerUrl",52,function(b,c){var d=b[x]("#"),e=b,f=a.jc();if(f)if(c&&1>=d[v])e+="#"+f;else if(!c||1>=d[v])1>=d[v]?e+=(R(b,
"?")?E:"?")+f:e=d[0]+(R(b,"?")?E:"?")+f+"#"+d[1];return e});a.nc=function(){var b=a.n,c=a.l,d=c.g(),e=a.a+"",f=L.Ya(),g,h=R(d,H+e+"."),i=R(d,ka+e),t=R(d,la+e),u,G=[],Y="",Ia=!1,d=M(d)?"":d;if(j.B&&!a.eb){g=L[w][y]&&L[w][y].hash?L[w][y][z][A](L[w][y][z][q]("#")):"";j.V&&!M(g)&&(Y=g+E);Y+=L[w][y].search;if(!M(Y)&&R(Y,H))c.Sb(Y),c.Ba()||c.Qb(),u=c.ca(),a.eb=!0;g=c.fa;var va=c.Pa,U=c.Sa;M(g())||(va(Q(g())),R(g(),";")||U());g=c.ea;va=c.Y;U=c.Z;M(g())||(va(g()),R(g(),";")||U())}M(u)?h?(u=!i||!t)?(u=m(d,
";",l(b)),a.F=!0):(u=N(d,H+e+".",";"),G=N(d,ka+e,";")[x](".")):(u=[e,a.mc(),b,b,b,1][C]("."),Ia=a.F=!0):M(c.C())||M(c.da())?(u=m(Y,E,l(b)),a.F=!0):(G=c.C()[x]("."),e=G[0]);u=u[x](".");L[s]&&f&&f.dh==e&&!j.p&&(u[4]=f.sid?f.sid:u[4],Ia&&(u[3]=f.sid?f.sid:u[4],f.vid&&(b=f.vid[x]("."),u[1]=b[0],u[2]=b[1])));c.Na(u[C]("."));G[0]=e;G[1]=G[1]?G[1]:0;G[2]=k!=G[2]?G[2]:j.Wb;G[3]=G[3]?G[3]:u[4];c.aa(G[C]("."));c.Oa(e);M(c.Rb())||c.ga(c.K());c.Qa();c.ba();c.Ra()};a.oc=function(){t=new Ka(j)};a.getName=c("_getName",
58,function(){return a.o});a.b=c("_initData",2,function(){var b;if(!i){if(!a.P)a.P=new La(j.na);a.a=a.lc();a.l=new Fa(j);a.d=new Na;u=new Ma(j,l(a.a),a.l,a.d);a.oc()}if(g()){if(!i)a.oa=a.kc(a.ab,L[w].domain),b=new Z(l(a.a),a.oa,a.n,j);a.nc(b);u.$b()}if(!i)g()&&b.Pb(a.l,a.F),a.bb=new Na,$.load(j,a.l),i=!0});a.Xa=c("_visitCode",54,function(){a.b();var b=N(a.l.g(),H+a.a+".",";"),b=b[x](".");return b[v]<4?"":b[1]});a.qd=c("_cookiePathCopy",30,function(b){a.b();a.l&&a.l.Ub(a.a,b)});a.z=function(){return a.Xa()%
1E4<j.L*100};a.re=c("_trackPageview",1,function(b){if(g())a.b(),a.uc(b),a.F=!1});a.te=c("_trackTrans",18,function(){var b=a.a,c=[],d,e,f;a.b();if(a.e&&a.z()){for(d=0;d<a.e.N[v];d++){e=a.e.N[d];T(c,e.ia());for(f=0;f<e.M[v];f++)T(c,e.M[f].ia())}for(d=0;d<c[v];d++)t.u(c[d],a.k,b,!0)}});a.me=c("_setTrans",20,function(){var b,c,d,e;b=L[w].getElementById?L[w].getElementById("utmtrans"):L[w].utmform&&L[w].utmform.utmtrans?L[w].utmform.utmtrans:k;a.b();if(b&&b.value){a.e=new W;e=b.value[x]("UTM:");j.w=!j.w||
""==j.w?"|":j.w;for(b=0;b<e[v];b++){e[b]=ya(e[b]);c=e[b][x](j.w);for(d=0;d<c[v];d++)c[d]=ya(c[d]);"T"==c[0]?a.$a(c[1],c[2],c[3],c[4],c[5],c[6],c[7],c[8]):"I"==c[0]&&a.ic(c[1],c[2],c[3],c[4],c[5],c[6])}}});a.$a=c("_addTrans",21,function(b,c,d,e,f,g,h,i){a.e=a.e?a.e:new W;return a.e.Xb(b,c,d,e,f,g,h,i)});a.ic=c("_addItem",19,function(b,c,d,e,f,g){var h;a.e=a.e?a.e:new W;(h=a.e.Va(b))||(h=a.$a(b,"","","","","","",""));h.Vb(c,d,e,f,g)});a.oe=c("_setVar",22,function(b){b&&""!=b&&e()&&(a.b(),u.bc(b),a.z()&&
t.u("&utmt=var",a.k,a.a))});a.Yd=c("_setCustomVar",10,function(b,c,d,e){a.b();return u.ac(b,c,d,e)});a.td=c("_deleteCustomVar",35,function(b){a.b();u.Yb(b)});a.Cd=c("_getVisitorCustomVar",50,function(b){a.b();return u.Zb(b)});a.fe=c("_setMaxCustomVariables",71,function(a){j.Ta=a});a.link=c("_link",101,function(b,c){j.B&&b&&(a.b(),L.ec(a.cb(b,c)))});a.Fd=c("_linkByPost",102,function(b,c){if(j.B&&b&&b.action)a.b(),b.action=a.cb(b.action,c)});a.pe=c("_setXKey",83,function(b,c,d){a.d.j(b,c,d)});a.qe=
c("_setXValue",84,function(b,c,d){a.d.ka(b,c,d)});a.Dd=c("_getXKey",76,function(b,c){return a.d.fc(b,c)});a.Ed=c("_getXValue",77,function(b,c){return a.d.gc(b,c)});a.od=c("_clearXKey",72,function(b){a.d.t(b)});a.pd=c("_clearXValue",73,function(b){a.d.ja(b)});a.sd=c("_createXObj",75,function(){a.b();return new Na});a.qc=c("_sendXEvent",78,function(b){var c="";a.b();a.z()&&(c+="&utmt=event&utme="+P(a.d.hc(b))+a.O(),t.u(c,a.k,a.a,!1,!0))});a.rd=c("_createEventTracker",74,function(b){a.b();return new Oa(b,
a)});a.Za=c("_trackEvent",4,function(b,c,d,e){a.b();var f=a.bb;k!=b&&k!=c&&""!=b&&""!=c?(f.t(5),f.ja(5),(b=f.j(5,1,b)&&f.j(5,2,c)&&(k==d||f.j(5,3,d))&&(k==e||f.ka(5,1,e)))&&a.qc(f)):b=!1;return b});a.Wa=c("_trackPageLoadTime",100,function(){a.b();if(!a.pa)a.pa=new Pa(a,t);return a.pa.Wa()});a.se=c("_trackSocial",104,function(b,c,d,e){if(!b||!c)return!1;a.b();if(!a.z())return!1;b="&utmt=social&utmsn="+P(b[A](0,15))+"&utmsa="+P(c[A](0,15))+"&utmsid="+P(d||L[w][y][z])+"&utme="+P(a.d.v())+a.O(e);t.u(b,
a.k,a.a,!1,!0);return!0});a.wd=function(){return j};a.ae=c("_setDomainName",6,function(a){j.c=a});a.kd=c("_addOrganic",14,function(a,b,c){j.J.splice(c?0:j.J[v],0,new Ca(a,b))});a.nd=c("_clearOrganic",70,function(){j.J=[]});a.hd=c("_addIgnoredOrganic",15,function(a){T(j.W,a)});a.ld=c("_clearIgnoredOrganic",97,function(){j.W=[]});a.jd=c("_addIgnoredRef",31,function(a){T(j.X,a)});a.md=c("_clearIgnoredRef",32,function(){j.X=[]});a.Id=c("_setAllowHash",8,function(a){j.Ua=a?1:0});a.Td=c("_setCampaignTrack",
36,function(a){j.Ka=a?1:0});a.Ud=c("_setClientInfo",66,function(a){j.la=a?1:0});a.vd=c("_getClientInfo",53,function(){return j.la});a.Vd=c("_setCookiePath",9,function(a){j.f=a});a.ne=c("_setTransactionDelim",82,function(a){j.w=a});a.Xd=c("_setCookieTimeout",25,function(b){a.rc(b*1E3)});a.rc=c("_setCampaignCookieTimeout",29,function(a){j.La=a});a.Zd=c("_setDetectFlash",61,function(a){j.na=a?1:0});a.xd=c("_getDetectFlash",65,function(){return j.na});a.$d=c("_setDetectTitle",62,function(a){j.ma=a?1:
0});a.yd=c("_getDetectTitle",56,function(){return j.ma});a.ce=c("_setLocalGifPath",46,function(a){j.ha=a});a.zd=c("_getLocalGifPath",57,function(){return j.ha});a.ee=c("_setLocalServerMode",92,function(){j.D=0});a.ie=c("_setRemoteServerMode",63,function(){j.D=1});a.de=c("_setLocalRemoteServerMode",47,function(){j.D=2});a.Ad=c("_getServiceMode",59,function(){return j.D});a.je=c("_setSampleRate",45,function(a){j.L=a});a.ke=c("_setSessionTimeout",27,function(b){a.sc(b*1E3)});a.sc=c("_setSessionCookieTimeout",
26,function(a){j.Ma=a});a.Jd=c("_setAllowLinker",11,function(a){j.B=a?1:0});a.Hd=c("_setAllowAnchor",7,function(a){j.V=a?1:0});a.Qd=c("_setCampNameKey",41,function(a){j.Ca=a});a.Md=c("_setCampContentKey",38,function(a){j.Da=a});a.Nd=c("_setCampIdKey",39,function(a){j.Ea=a});a.Od=c("_setCampMediumKey",40,function(a){j.Fa=a});a.Pd=c("_setCampNOKey",42,function(a){j.Ga=a});a.Rd=c("_setCampSourceKey",43,function(a){j.Ha=a});a.Sd=c("_setCampTermKey",44,function(a){j.Ia=a});a.Ld=c("_setCampCIdKey",37,function(a){j.Ja=
a});a.ud=c("_getAccount",64,function(){return a.k});a.Gd=c("_setAccount",3,function(b){a.k=b});a.ge=c("_setNamespace",48,function(a){j.p=a?P(a):k});a.Bd=c("_getVersion",60,function(){return ha});a.Kd=c("_setAutoTrackOutbound",79,Ba);a.le=c("_setTrackOutboundSubdomains",81,Ba);a.be=c("_setHrefExamineLimit",80,Ba);a.he=c("_setReferrerOverride",49,function(b){a.ab=b});a.Wd=c("_setCookiePersistence",24,function(b){a.tc(b)});a.tc=c("_setVisitorCookieTimeout",28,function(a){j.s=a})};var Ra=function(){var d=this,f=sa(d);d.wb=!1;d.Ib={};d.bd=0;d._gasoDomain=k;d._gasoCPath=k;d.we=f("_getTracker",0,function(b,f){return d.za(b,k,f)});d.za=f("_createTracker",55,function(b,d,e){d&&K(23);e&&K(67);d==k&&(d="~"+V.bd++);return V.Ib[d]=new Qa(d,b,e)});d.Hb=f("_getTrackerByName",51,function(b){b=b||"";return V.Ib[b]||V.za(k,b)});d.pb=function(){var b=L.Vc();return b&&b[ja]&&b[ja]()};d.ve=f("_anonymizeIp",16,function(){d.wb=!0})};var Ta=function(){var d=this,f=sa(d);d.ye=f("_createAsyncTracker",33,function(b,d){return V.za(b,d||"")});d.ze=f("_getAsyncTracker",34,function(b){return V.Hb(b)});d.push=function(b){K(5);for(var d=arguments,e=0,f=0;f<d[v];f++)try{if(typeof d[f]==="function")d[f]();else{var g="",a=d[f][0],c=a.lastIndexOf(".");c>0&&(g=a[A](0,c),a=a[A](c+1));var t=g==fa?V:g==ga?Sa:V.Hb(g);t[a].apply(t,d[f].slice(1))}}catch(j){e++}return e}};var V=new Ra;var Ua=L[s][fa];Ua&&typeof Ua._getTracker=="function"?V=Ua:L[s][fa]=V;var Sa=new Ta;a:{var Va=L[s][ga],Wa=!1;if(Va&&typeof Va[ba]=="function"&&(Wa=ua(Va),!Wa))break a;L[s][ga]=Sa;Wa&&Sa[ba].apply(Sa,Va)};})();
