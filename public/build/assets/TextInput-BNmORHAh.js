import{E as r,B as l,s as n,i as d,G as i,o as c,f}from"./app-Xp4tkxNa.js";const v={__name:"TextInput",props:{modelValue:{type:String,required:!0},modelModifiers:{}},emits:["update:modelValue"],setup(s,{expose:t}){const o=r(s,"modelValue"),e=l(null);return n(()=>{e.value.hasAttribute("autofocus")&&e.value.focus()}),t({focus:()=>e.value.focus()}),(m,u)=>d((c(),f("input",{class:"border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm","onUpdate:modelValue":u[0]||(u[0]=a=>o.value=a),ref_key:"input",ref:e},null,512)),[[i,o.value]])}};export{v as _};
