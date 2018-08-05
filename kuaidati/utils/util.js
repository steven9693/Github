const debug_api = true;
var app = getApp();
function formatTime(date) {
  var year = date.getFullYear()
  var month = date.getMonth() + 1
  var day = date.getDate()

  var hour = date.getHours()
  var minute = date.getMinutes()
  var second = date.getSeconds()


  return [year, month, day].map(formatNumber).join('/') + ' ' + [hour, minute, second].map(formatNumber).join(':')
}

function formatNumber(n) {
  n = n.toString()
  return n[1] ? n : '0' + n
}

function apiV1(url, data, success, isPost = false, isLoading = true, error) {
  wx.request({
    url:url,
    data,
    method: `${isPost ? 'POST' : 'GET'}`,
    header: {
      'content-type': `${isPost ? 'application/x-www-form-urlencoded' : 'application/json'}`
    },
    success: function (res) {
      // debug_api && console.log(url);
      // debug_api && console.log(res);
      success(res.data);
      isLoading && wx.hideToast();
    },
    fail: function (error) {
      // debug_api && console.log(url);
      // debug_api && console.log(error);
      // error && error(error);
      isLoading && wx.hideToast();
    }
  });
}

function api(url, data, success, isPost = false, isLoading = true, error, isnoid = false) {

  // if(isPost) {
  //   data = json2Form(data);
  // }
  // debug_api && console.log(url);
  // debug_api && console.log(data);
  isLoading && wx.showToast({
    title: '正在加载',
    icon: 'loading',
    duration: 10000
  })
  wx.request({
    url: HOST + url,
    data,
    method: `${isPost ? 'POST' : 'GET'}`,
    header: {
      'content-type': `${isPost ? 'application/x-www-form-urlencoded' : 'application/json'}`
    },
    success: function (res) {
      // debug_api && console.log(url);
      // debug_api && console.log(res);
      success(res.data);
      isLoading && wx.hideToast();
    },
    fail: function (error) {
      // debug_api && console.log(url);
      //debug_api && console.log(error);
      // error && error(error);
      isLoading && wx.hideToast();
    }
  });

}

/**
 * html解码   用于文本块的解码
 * Created by hw.lee on 2015/7/3
 */
function html_decode(str) {
  var s = "";
  if (str.length == 0)
    return "";
  s = str.replace(/&#62;|&gt;/g, ">");
  s = s.replace(/&#60;|&lt;/g, "<");
  s = s.replace(/&#160;|&nbsp;/g, " ");
  s = s.replace(/&#39;/g, "'");
  s = s.replace(/&#34;/g, "\"");
  s = s.replace(/&#38;/g, "&");
  // s = s.replace(/<br\s*\/?>/g, "\n");
  return s;
}

function json2Form(json) {
  var str = [];
  for (var p in json) {
    str.push(encodeURIComponent(p) + "=" + encodeURIComponent(json[p]));
  }
  return str.join("&");
}

function formatEvatime(time)
{
  //time是整数，否则要parseInt转换
  let unixtime = time
  let unixTimestamp = new Date(unixtime * 1000)
  let Y = unixTimestamp.getFullYear()
  let M = ((unixTimestamp.getMonth() + 1) > 10 ? (unixTimestamp.getMonth() + 1) : '0' + (unixTimestamp.getMonth() + 1))
  let D = (unixTimestamp.getDate() > 10 ? unixTimestamp.getDate() : '0' + unixTimestamp.getDate())
  let toDay = Y + '-' + M + '-' + D
  return toDay
}




module.exports = {
  formatTime: formatTime,
  api: api,
  apiV1: apiV1,
  html_decode: html_decode,
  formatEvatime:formatEvatime
}
