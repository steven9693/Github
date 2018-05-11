/*
  version 1.0
 */

/*
  封装的微信请求API
  URL 接口地址
  data 请求参数
  success 回调函数
 */

function getRequest(url, data, success, isPost = false, isLoading = true, error) {
  wx.request({
    url: url,
    data,
    method: `${isPost ? 'POST' : 'GET'}`,
    header: {
      'content-type': `${isPost ? 'application/x-www-form-urlencoded' : 'application/json'}`
    },
    success: function (res) {
      success(res.data);
      isLoading && wx.hideToast();
    },
    fail: function (error) {
      isLoading && wx.hideToast();
    }
  });
}


/*
  获取系统信息
*/
function getSystemInfo(success,fail=false,complete=false,){
  wx.getSystemInfo({
    success: function (res) {
      success(res)
    },
    fail:function(){

    },
    complete:function(){

    }

  })
}


/*
  默认的弹出层提示
*/
function showModal(title = "标题", content = '内容', success, cancel, showCancel=true){
  wx.showModal({
    title: title,
    content: content,
    showCancel,
    success: function (res) {
      if (res.confirm) {
        success&&success()
      } else if (res.cancel) {
        cancel&&cancel()
      }
    }
  })
}

/*
  显示 loading 提示框
 */
function showLoading(title = '加载中...', mask = false){
  wx.showLoading({
    title: title,
    mask
  })
}

/*
  隐藏 loading 提示框
  默认直接隐藏loading提示层
  存在参数的时候设置时间间隔
 */

function hideLoading(timeout=true,time=2000){
  if (timeout){
    wx.hideLoading()
  }else{
    setTimeout(function () {
      wx.hideLoading()
    }, time)
  }
}

/*
  showToast
  显示消息提示框

  title	String	是	提示的内容
  icon	String	否	图标，有效值 "success", "loading", "none"
  image	String	否	自定义图标的本地路径，image 的优先级高于 icon	1.1.0
  duration	Number	否	提示的延迟时间，单位毫秒，默认：1500
  mask	Boolean	否	是否显示透明蒙层，防止触摸穿透，默认：false
  success	Function	否	接口调用成功的回调函数
  fail	Function	否	接口调用失败的回调函数
  complete	Function	否	接口调用结束的回调函数（调用成功、失败都会执行）

 */

function showToast(title = '成功', icon = 'success', duration=1500){
  wx.showToast({
    title,
    icon,
    duration
  })
}


/*
  获取用户的openid
 */

function toLogin(url,callback){
  wx.login({
    success: function (res) {
      var code = res.code;
      wx.login({
        success: function (res) {
          var code = res.code;
          wx.request({
            url: url,
            data: {
              code: res.code,
            },
            header: {
              'content-type': 'application/x-www-form-urlencoded' // 默认值
            },
            method: "POST",
            success: function (res) {
              let {data}=res;
              wx.setStorageSync('userInfo', data);
              callback && callback(data)
            }
          })
        }
      })

      
    }
  })

}


/*
  获取用户信息
*/

function getUserInfo(url,callback){

  wx.login({
    success: function success(res) {
      var code = res.code;
      wx.getUserInfo({
        withCredentials:true,
        lang:'zh_CN',
        success: res => {
          let { iv, encryptedData,userInfo}=res;
          let data={};
          data['iv']=iv;
          data['encryptedData'] = encryptedData;
          data['code']=code;
          data['headurl'] = userInfo['avatarUrl'];
          data['gender'] = userInfo['gender'];
          data['nickname'] = userInfo['nickName'];
          data['city'] = userInfo['city'];
          data['province'] = userInfo['province'];

          wx.request({
            url: url,
            data:data,
            header: {
              'content-type': 'application/x-www-form-urlencoded' // 默认值
            },
            method: "POST",
            success: function (res) {
              let { data } = res;
              wx.setStorageSync('userInfo', data);
              callback && callback(data);
            }
          })

        }
      })
    }
  })

}






module.exports = {
  getRequest, 
  getSystemInfo,
  showModal,
  showLoading,
  hideLoading,
  showToast,
  toLogin,
  getUserInfo
}