// pages/exchange/exchange.js
import { getSystemInfo, getRequest} from './../../utils/wxApi';
Page({

  /**
   * 页面的初始数据
   */
  data: {
  
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    console.log(getSystemInfo)
    //console.log(A)

    //匿名函数

    /*
    ((demo)=>{
      console.log(demo)
    })('aaaa');

    (function(a){
      console.log(a)
    })('11223')

    const obj={
      name:'obj',
      getname(){
        console.log(this.name)
      }

    }
    obj.getname()

    const arg={name:'arg',age:11}

    fn= b =>{
        console.log(b.name)
    }

    fn(arg);


  ff('fuck ES6');

  (aa=>{
    aa=aa+ ' WORLD!'
    console.log(aa)
  })('is run');

  function func(arg){
    let f=arg
    console.log(f);
  }

  func(123);


  let [c,d]=[20,30];
  console.log(c)
  console.log(d)

  let res={status:1,user:{name:'tt',age:11}}

  let{status,user}=res;
  console.log(status);
  console.log(user);

  const q = (a,b) => {
    console.log(a+b)
  }

  q(2,6);

  let a=()=>{
    console.log(33)
  };

  console.log(a());

  function add(...values) {
    let sum = 0;

    for (var val of values) {
      sum += val;
    }

    return sum;
  }

  console.log(add(2, 5, 3,4)) // 10
*/
/*
  let res = { status: 551, user: { name: 'ss', age: '11' } }
  let w=re=>{
    let {status,user}=re
    console.log(status);
    console.log(user);
  }
  w(res);

  console.log(...[1,2,3])

  let q=function(x,y){
    console.log(x)
    console.log(y)
  }
  q(...[1,2]);

  let a1=[1,2];
  let a2=[3,4];
  a1.push(...a2)
  console.log(a1)
  console.log(a1.concat(a2))

  let obj={
    method(){
      console.log('method 1 2 3')
    }
  }
  obj.method()

  console.log(obj.method.name)


  let o={name:22};
  let oo=o;
  console.log(Object.is(o,oo))

*/
/*
  let obj={
    name:'obj',
    getname(){}
    };
  let target={}
  Object.assign(target,obj);
  console.log(target)
  let t=Object.is(target,target)
  console.log(t)

  Object.getOwnPropertyDescriptors(obj)
*/
/*
    const proto = {
      foo: 'hello'
    };

    const obj = {
      find() {
        return super.foo;
      }
    };

    Object.setPrototypeOf(obj, proto);
    console.log(obj.foo)
    console.log(obj.find()) // "hello"

*/
/*
    let promise = new Promise(function (resolve, reject) {
      console.log('Promise');
      resolve();
      reject();
    });

    promise.then(function () {
      console.log('resolved.');
    },function(){
      console.log('reject');
    });

*/





  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {
  
  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {
  
  },

  /**
   * 生命周期函数--监听页面隐藏
   */
  onHide: function () {
  
  },

  /**
   * 生命周期函数--监听页面卸载
   */
  onUnload: function () {
  
  },

  /**
   * 页面相关事件处理函数--监听用户下拉动作
   */
  onPullDownRefresh: function () {
  
  },

  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom: function () {
  
  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {
  
  }
})