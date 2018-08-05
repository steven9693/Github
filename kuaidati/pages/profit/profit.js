// pages/profit/profit.js

import { URL_PROFITLIST } from '../../utils/urls';
import { apiV1 } from '../../utils/util';


Page({

  /**
   * 页面的初始数据
   */
  data: {
    lists:[],
    money:'0.00',
    nodata:0
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
    var userinfo = wx.getStorageSync('userInfo');
    var that=this;
    apiV1(URL_PROFITLIST,{user_id:userinfo.id},data=>{
      console.log(data);
      if(data.status==1){
        //查询到数据
        that.setData({lists:data.data,money:data.money,nodata:1})
      }else{
        that.setData({money: data.money,nodata:0})
      }

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
  
  }


})