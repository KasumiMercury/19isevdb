if(!self.define){let e,s={};const r=(r,i)=>(r=new URL(r+".js",i).href,s[r]||new Promise((s=>{if("document"in self){const e=document.createElement("script");e.src=r,e.onload=s,document.head.appendChild(e)}else e=r,importScripts(r),s()})).then((()=>{let e=s[r];if(!e)throw new Error(`Module ${r} didn’t register its module`);return e})));self.define=(i,o)=>{const t=e||("document"in self?document.currentScript.src:"")||location.href;if(s[t])return;let n={};const c=e=>r(e,t),d={module:{uri:t},exports:n,require:c};s[t]=Promise.all(i.map((e=>d[e]||c(e)))).then((e=>(o(...e),n)))}}define(["./workbox-604030d5"],(function(e){"use strict";self.skipWaiting(),e.clientsClaim(),e.precacheAndRoute([{url:"//js/app.js",revision:"90a9be003d0829ca752b01876207b91f"},{url:"//js/app.js.LICENSE.txt",revision:"40341c58f2c127ee11e061d1a747ca2d"},{url:"//js/ogp.js",revision:"380d5b548ce0a3687bc6a1eb417365c2"},{url:"//js/ogp.js.LICENSE.txt",revision:"fcd8f71fa91f2bbb89ab92c4f8613d59"},{url:"/css/app.css",revision:"6318e5b93842f9149a5203cda8ed2e76"}],{}),e.registerRoute(/\//,new e.StaleWhileRevalidate,"GET")}));
