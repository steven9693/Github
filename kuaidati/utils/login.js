function sysGetUserInfo(e, openid, that) {
  var tempUser = e.detail.userInfo;
  var encryptedData = e.detail.encryptedData;
  var iv = e.detail.iv;
  var session_key = wx.getStorageSync('session_key');
  console.log(e.detail);
  wx.checkSession({
    success: function () {
      //session_key 未过期，并且在本生命周期一直有效
      apiV1(URL_UPDATEUSERINFO, { openid: openid, nickname: tempUser.nickName, headimgurl: tempUser.avatarUrl, gender: tempUser.gender, encryptedData: encryptedData, iv: iv, session_key: session_key }, data => {

        // console.log(encryptedData);
        if (data.status == 1) {
          var userInfo = wx.getStorageSync("userInfo");
          userInfo.nickname = tempUser.nickName;
          userInfo.headimg = tempUser.avatarUrl;
          userInfo.sex = tempUser.gender;
          userInfo.unionid = data.unionid;
          wx.setStorageSync("userInfo", userInfo);
        }

        that.setData({
          isToalert: false
        })
      }, true)
    },
    fail: function () {
      // session_key 已经失效，需要重新执行登录流程
      wx.login({
        success: function (res) {
          var code = res.code;
          apiV1(URL_UPDATEUSERINFO, { openid: openid, nickname: tempUser.nickName, headimgurl: tempUser.avatarUrl, gender: tempUser.gender, encryptedData: encryptedData, iv: iv, code: code }, data => {

            // console.log(encryptedData);
            if (data.status == 1) {
              var userInfo = wx.getStorageSync("userInfo");
              userInfo.nickname = tempUser.nickName;
              userInfo.headimg = tempUser.avatarUrl;
              userInfo.sex = tempUser.gender;
              userInfo.unionid = data.unionid;
              wx.setStorageSync("userInfo", userInfo);
            }

            that.setData({
              isToalert: false
            })
          }, true)
        }
      })
    }
  })
}

module.exports = {
  sysGetUserInfo: sysGetUserInfo
}