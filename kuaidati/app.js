import { URL_USER_LOGIN, URL_USER_CODE, URL_USER_UPDATE } from './utils/urls';
import { apiV1 } from './utils/util';

//app.jsi
App({
  getRoomPage: function () {
    return this.getPage("pages/customerService/customerService")
  },
  getPage: function (pageName) {
    var pages = getCurrentPages()
    return pages.find(function (page) {
      return page.__route__ == pageName
    })
  },
  onLaunch: function () {
    this.getUserInfo();
    wx.removeStorageSync('counponInfo');

    //调用API从本地缓存中获取数据
    var that = this
    var logs = wx.getStorageSync('logs') || []
    logs.unshift(Date.now())
    wx.setStorageSync('logs', logs)

  },
  getOpenid:function(code,callback){
    console.log('getopenid')
    var that = this;
    // wx.login({
    //   success: function (res) {
    //     var code = res.code;
    apiV1(URL_USER_CODE,{code:code},data=>{
      console.log(data);
      var tempData = data.data;
      wx.setStorageSync('userInfo', tempData);
      wx.setStorageSync("session_key", data.session_key);
      callback && callback();
    },true)
    //   }
    // })
  },
  getUserInfo: function (callback) {
    var that = this;
    if (!wx.getStorageSync('userInfo')) {
      console.log(111)
        wx.login({
          success: function (res) {
            var code = res.code;
            console.log(code)
            wx.getUserInfo({
              success: function (res) {
                console.log('getUserInfo')
                console.log(res);

                var userInfo = res.userInfo;

                apiV1(URL_USER_LOGIN, { encryptedData: res.encryptedData, iv: res.iv, code: code, nickname: userInfo.nickName, headimgurl: userInfo.avatarUrl, gender: userInfo.gender }, data => {
                  var tempData = data.data;
                  wx.setStorageSync('userInfo', tempData);
                  callback && callback();
                }, true)
              },
              fail: function () {
                // fail
                //that.getOpenid(code,callback);//不授权则获取openid
              },
              complete: function () {
                // complete
              }
            })
          },
          fail: function () {
            // fail
          },
          complete: function () {
            // complete
          }
        })
    }else{
      console.log(222)
      if(!wx.getStorageSync('userInfo').unionid){
        wx.login({
          success: function (res) {
            var code = res.code;
            console.log(res);
            wx.getUserInfo({
              success: function (res) {
                console.log(res);
                // success
                var userInfo = res.userInfo;

                apiV1(URL_USER_LOGIN, { encryptedData: res.encryptedData, iv: res.iv, code: code, nickname: userInfo.nickName, headimgurl: userInfo.avatarUrl, gender: userInfo.gender }, data => {
                  console.log(data)
                  if(data.status==1){
                    var tempData = data.data;
                    wx.setStorageSync('userInfo', tempData);
                  }
                }, true)
                callback && callback();
              },
              fail: function () {
                // fail
                that.getOpenid(code);//不授权则获取openid
              },
              complete: function () {
                // complete
              }
            })
          },
          fail: function () {
            // fail
          },
          complete: function () {
            // complete
          }
        })
      }
    }
  },

  globalData: {
    userInfo: null,
    chatMsg: [],
    code: null,
    sysInfo: null,
    uid: 1,
    //用户收货地址
    useraddress: '',
    defaultAdd: '',
  }
})
function json2Form(json) {
  var str = [];
  for (var p in json) {
    str.push(encodeURIComponent(p) + "=" + encodeURIComponent(json[p]));
  }
  return str.join("&");
}





