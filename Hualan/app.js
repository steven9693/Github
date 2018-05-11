//app.js
/*
import { toLogin, getUserInfo } from './utils/wxApi.js';
import { URL_AUTHORCODE, URL_LOGIN } from './utils/urls.js';
*/
App({
  onLaunch: function () {
/*
    getUserInfo(URL_LOGIN,function(){
      let userInfo = wx.getStorageSync('userInfo');
      console.log(userInfo);
    })
*/
    //toLogin(URL_AUTHORCODE,function(data){
    //  console.log(data)
    //})


    //this.tologin(function(){})
    // 展示本地存储能力
    /*
    var logs = wx.getStorageSync('logs') || []
    logs.unshift(Date.now())
    wx.setStorageSync('logs', logs)

    // 登录
    wx.login({
      success: res => {
        // 发送 res.code 到后台换取 openId, sessionKey, unionId
      }
    })
    // 获取用户信息
    wx.getSetting({
      success: res => {
        if (res.authSetting['scope.userInfo']) {
          // 已经授权，可以直接调用 getUserInfo 获取头像昵称，不会弹框
          wx.getUserInfo({
            success: res => {
              // 可以将 res 发送给后台解码出 unionId
              this.globalData.userInfo = res.userInfo

              // 由于 getUserInfo 是网络请求，可能会在 Page.onLoad 之后才返回
              // 所以此处加入 callback 以防止这种情况
              if (this.userInfoReadyCallback) {
                this.userInfoReadyCallback(res)
              }
            }
          })
        }
      }
    })

    */
  },


  tologin: function (callback) {
    var that = this
    wx.login({
      success: function (res) {
        var code = res.code;

        wx.request({
          url: URL_AUTHORCODE,
          data: {
            code: res.code,
          },
          header: {
            'content-type': 'application/x-www-form-urlencoded' // 默认值
          },
          method: "POST",
          success: function (res) {
            console.log('--login---')
            console.log(res.data)
            that.globalData.userInfo = res.data;
            wx.setStorageSync('userInfo', res.data);
            callback && callback(that)
          }
        })

      }
    })
  },








  globalData: {
    userInfo: null
  }
})