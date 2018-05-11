// pages/canvas/canvas.js

var wxDraw = require("../../utils/wxdraw.js").wxDraw;
var Shape = require("../../utils/wxdraw.js").Shape;

Page({

  /**
   * 页面的初始数据
   */
  data: {
    userInfo: {},
    hasUserInfo: false,
    wxCanvas: null //    需要创建一个对象来接受wxDraw对象
  
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var context = wx.createCanvasContext('first');//还记得 在wxml里面canvas的id叫first吗
    this.wxCanvas = new wxDraw(context, 0, 0, 320, 400);

    var rect = new Shape('circle', {
      x: 100, y: 100, w: 20, h: 20,
      lineWidth: 20, fillStyle: "#cccccc",isLineDash:true,
      lineDash: [[5, 5], 5], needShadow:true,
    }, 'stroke', true);

    this.wxCanvas.add(rect);
    rect.animate({"rotate": "5"}, { duration: 1000 }).start(true)


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