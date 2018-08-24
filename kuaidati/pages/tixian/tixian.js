// pages/tixian/tixian.js

import { URL_MYWALLET, URL_TRANSFERS, URL_REDUCECOUNT } from '../../utils/urls';
import { apiV1 } from '../../utils/util';
var startFollowAni, endFollowAni;
Page({

  /**
   * 页面的初始数据
   */
  data: {
    money:'0.00',
    setall:'', //全部提现
    setbtn:0, //0 是默认的不可点击 1是可以点击提现
    num:0, //设置要取出来的金额
    iserror:0, // 1 提现金额大于可提现金额
    notice:0,
    kefu:0,
    lessten:0,
    submitLock:0,
    tofocus:0,
    focuslbcaijing:0
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
  
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
    var that=this;

    this.setData({
      kefu:0
    })
    var userinfo=wx.getStorageSync('userInfo');
    apiV1(URL_MYWALLET,{user_id:userinfo.id},data=>{
      console.log(data);
       that.setData({'money':data.money})
      // that.setData({ 'money': 10 })
    },true)
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


  toprofit:function(){
    wx.navigateTo({
      url: '/pages/profit/profit'
    })
  },

  getall:function(){
    var all=this.data.money;
    if(all>0){
      this.setData({ setall: all, setbtn: 1, num: all });
    }
  },


  //提现
  togetout:function(){
    var userinfo = wx.getStorageSync('userInfo');
    var openid = wx.getStorageSync('userInfo').openid;
    var num=this.data.num;
    var money=this.data.money;
    var that=this


    this.setData({ setbtn:0}) //锁住提交按钮

    console.log(money)
    console.log(num)
     if(num==0){
      return;
     }
    if(num>parseFloat(money)){
      this.setData({ iserror:1});
    }else{
      //发起提现小于1
      
      if (num>=1){

        apiV1(URL_TRANSFERS,{openid:openid,num:num},data=>{
          console.log(data)

          if(data.status==1){
            that.setData({ focuslbcaijing:1})
          }
          //
          if (data.return_code == 'SUCCESS' && (!data.return_msg.length)){
            //提现成功
            that.setData({ notice: 1 })
            // var user = wx.getStorageSync('userInfo');
            apiV1(URL_REDUCECOUNT, { openid: openid, num: num },da=>{
              console.log(da)
              if(da.status==1){
                userinfo['money']=da.data.money;
                that.setData({ money: da.data.money});
                wx.setStorageSync('userInfo', userinfo);
              }
            },true);

          }

        },true)

       }else{
         this.setData({ lessten: 1 });
       }

      // this.setData({ notice:1})
      // console.log(num);
      // apiV1(URL_TRANSFERS,{openid:openid,num:num},data=>{
      //   console.log(data)
      // },true)

    }
  },


  //设置iserror的值为0

  hideerror:function(){
    this.setData({ iserror: 0 })
  },


  hidelessten:function(){
    this.setData({ lessten: 0 })
  },

  tofocus:function(){
    this.setData({ tofocus:1})
  },




  //设置要去出来的钱
  setgetmoney:function(e){
    this.setData({ num: e.detail.value, setbtn:1})
  },

  nextnotice:function(){
    this.setData({
      notice:0,
      kefu:1
    })
  },



  showFollow: function () {
    var animation = wx.createAnimation({
      duration: 1000,
      timingFunction: 'ease',
    })

    this.animation = animation


    startFollowAni = setInterval(function () {
      animation.translateY(-10).step();
      this.setData({
        animationData: animation.export()
      })
    }.bind(this), 500)

    endFollowAni = setInterval(function () {
      animation.translateY(10).step();
      this.setData({
        animationData: animation.export()
      })
    }.bind(this), 1000)

    this.setData({
      isFollow: true
    })


  },

  hidefocusbox:function(){
    this.setData({ focuslbcaijing:0})
  }





})