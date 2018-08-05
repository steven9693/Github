// pages/userceter/userceter.js

import { URL_USER_LOGIN, URL_UPDATETODAY } from '../../utils/urls';
import { apiV1 } from '../../utils/util';


Page({

  /**
   * 页面的初始数据
   */
  data: {
    userInfo:{
      nickname:'昵称',
      headimgurl:'../../images/user.png',
      money:'0.00',
      errorcount: 0,
      rightcount: 0,
      todayprofitcount:0
    },
    todaycount: 0
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
    if(wx.getStorageSync('userInfo')){
      var userInfo = wx.getStorageSync('userInfo')
      this.setData({ 'userInfo': userInfo})
      var openid = userInfo.openid

      apiV1(URL_UPDATETODAY, { openid: openid},function(ret){
        console.log(ret);
        if(ret.status==1){
          var todaycount = ret.data.todaycount
          that.setData({ todaycount: todaycount})
        }
      },true)


    }

    
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
  
  },

  bindGetUserInfo: function (e) {
    var that=this;
    console.log(e)
    
    if (!e.detail.userInfo){
      return;
    }

    var userinfo = e.detail.userInfo;

    if(wx.getStorageSync('userInfo')){ //存在session直接登录
      wx.navigateTo({
        url: '/pages/questions/questions'
      })
      return;
    }
    wx.login({
      success: function (res) {
        var code = res.code;
        console.log('bindGetUserInfo');
        apiV1(URL_USER_LOGIN, { nickname: userinfo.nickName, headimgurl: userinfo.avatarUrl, gender: userinfo.gender, encryptedData: e.detail.encryptedData, iv: e.detail.iv, code: code }, data => {
          // console.log(encryptedData);
          console.log(data)
          if (data.status == 1) {
            that.setData({'userInfo':data.data});
            wx.setStorageSync("userInfo", data.data);
            wx.navigateTo({
              url: '/pages/questions/questions'
            })
          }
        }, true)
      }
    })

  },


  towallet: function () {
    if(wx.getStorageSync('userInfo')){
      wx.navigateTo({
        url: '/pages/tixian/tixian'
      })
    }

  }

  
})