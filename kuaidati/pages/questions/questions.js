// pages/questions/questions.js

import { URL_GET_QUESTIONS, URL_ANSWER, URL_CREATECASE, URL_PROFITTIME, URL_GETIMAGE, URL_GETQUESTION } from '../../utils/urls';
import { apiV1 } from '../../utils/util';
const app = getApp()

Page({

  /**
   * 页面的初始数据
   */
  data: {
    userInfo:{},
    questions:[], //获取关卡的所有题目
    index:0, //当前的回答的题目索引
    currentQ:{}, //当前回答的题目
    isstart:0, //判断是否开始答题，开始作答为1，
              //每开始一题都进行初始化 0,
              //提示未选择答案选项 2
    isover:0, //结束当前答题,其他的按钮停止点击
    iserror:0, //回答错误的时候为1，默认为0

    num:1,   //今天的答题次数;为 0 时候答题次数用完

    goon:0, //显示继续答题按钮 1 默认为0

    toshare:0, // 0 还有答题次数; 1 需要分享获得答题次数
    tosharenote:0, //显示当前答题次数以用完

    answerright:0, //回答对了，获得一个随机红包
    openhongbao:0, //打开红包查看金额
    hongbaolock:0, //防止数据重复提交
    cash:0, //答题正确获得的当次奖励
    overbox:0, //今天不能答题了 0默认可以答题 1不能答题

    sharesuccess:0,

    animationData: {},
    isFollow: false,
    isloading:0, //显示加载

    hadanswer:0, //扫码过来，
    isshare:0


  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {

    var that = this;
    var userInfo = wx.getStorageSync('userInfo');
    var currentQ = wx.getStorageSync('currentQ');

    var frompic=wx.getStorageSync('frompic');

    wx.getSystemInfo({
      success: function (res) {
        that.setData({
          width: (res.windowWidth-30),
          height: res.windowHeight,
        })
      }
    })

    if (wx.getStorageSync('frompic')){ //判断是否扫码进来的
      apiV1(URL_GETQUESTION, { id: frompic, uid: userInfo.id},function(res){ //检测是否答过这道题
        wx.removeStorageSync('frompic') //移除参数 
        wx.removeStorageSync('questions') //删除缓存里的题目
        console.log(res);
        if(res.status==1){ //已经回答过的问题
          that.setData({ hadanswer: 1, currentQ: res.data});
        }else{
          that.setData({ currentQ: res.data });
        }

      },true)
    }else{



    }

  },




  setcurrentQ:function(index){
    //设置当前的题目
    console.log('-------setcurrentQ------')
    console.log(index);
    var that=this;
    //保存当前的题目索引
    // wx.setStorageSync('tmindex', index);

    var len=this.data.questions.length;
    if(len!=index){
      //到了最后一题；
      var currentQ = this.data.questions[index];
      index+=1;
      var data = {
          currentQ: currentQ, 
          index: index, 
          iserror: 0, 
          isover: 0, 
          isstart: 0,
          goon: 0 
      }
      this.setData(data)

    }else{
      //更换题目
      console.log('回答完了');
      //重新加载题目

    }
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
    console.log('show---')
    var userinfo=wx.getStorageSync('userInfo');
    var that=this;

    var userInfo = wx.getStorageSync('userInfo');
    var currentQ = wx.getStorageSync('currentQ');

     wx.showShareMenu({
       withShareTicket: true
     })

    if (this.data.openhongbao==1){
      console.log('openhongbao')
      this.setData({ openhongbao: 0, hongbaolock:0})
      this.nextquestion();
    }

    if (!wx.getStorageSync('frompic')){

      if (currentQ && (!currentQ.right)) {
        var questions = wx.getStorageSync("questions");
        var tmindex = 0
        for (var i = 0; i < questions.length; i++) {
          if (currentQ.id == questions[i].id) {
            tmindex = i;
            console.log(tmindex)
            that.setData({ index: (tmindex + 1) });
            break;
          }
        }
        if(that.data.isshare==1){ //通过分享刷的页面
          that.setData({ currentQ: currentQ, 'questions': questions });
        }else{
          that.setData({ currentQ: currentQ, toshare: 1, 'questions': questions });
        }
        
      } else {

        apiV1(URL_GET_QUESTIONS, { user_id: userInfo.id }, function (ret) {
          console.log(ret)
          if (ret.status == 1) {
            that.setData({ 'questions': ret.data });
            // that.setcurrentQ(that.data.index);
            that.setcurrentQ(0);
            wx.setStorageSync('questions', ret.data)
            // console.log(that.data.currentQ)
          }
        }, true);

      }


    }




    //今天的答题次数用完了

    apiV1(URL_PROFITTIME, { openid: userinfo.openid},function(ret){
      // console.log(ret)
      if (ret.status == 1 && ret.todayprofittimes>=2){
        wx.removeStorageSync('currentQ'); //移除缓存里的题目
        that.setData({ overbox: 1, toshare: 0, hadanswer:0});
        
      }
    },true)

    // if (userinfo.profittimes>=2){
    //   this.setData({ overbox:1})
    // }

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
  onShareAppMessage: function (e) {
     console.log(e)
    var that=this;
/*
    return {
      title: '快帮帮我，这道题有点难！',
      path: 'pages/userceter/userceter',
      success:function(e){
        //var userinfo=wx.getStorageSync('userInfo')
        //if (userinfo.profittimes<2){
          //今天还能继续答题
          // wx.removeStorageSync('currentQ')
        that.setData({ toshare: 0, sharesuccess: 1, isshare:1 })
        //}
      

      //   console.log('onShareAppMessage success')
      //   //分享成功回调；
        //  var share=wx.getStorageSync('toshare');
        //  share.toshare=0
        //  wx.setStorageSync('toshare',share)
        //  that.setData({ goon:1, toshare:0,num:1})
      },
      fail:function(){
      //   console.log('onShareAppMessage fail')
      }
    }
*/

    return {
      title: '快帮帮我，这道题有点难！',
      path: 'pages/userceter/userceter',
      success: function (res) {

        //getSystemInfo是为了获取当前设备信息，判断是android还是ios，如果是android
        //还需要调用wx.getShareInfo()，只有当成功回调才是转发群，ios就只需判断shareTickets
        //获取用户设备信息
        // console.log(e)
        wx.getSystemInfo({
          success: function (d) {
            // console.log(d);
            //判断用户手机是IOS还是Android
            if (d.platform == 'android') {
              wx.getShareInfo({//获取群详细信息
                shareTicket: res.shareTickets,
                success: function (res) {
                  console.log('android 群')
                  //这里写你分享到群之后要做的事情，比如增加次数什么的
                  console.log(e)
                  if (e.target.dataset.id == 'isshare') {
                    that.setData({ toshare: 0, sharesuccess: 1, isshare: 1 })
                  }
                },
                fail: function (res) {//这个方法就是分享到的是好友，给一个提示
                  console.log('android 个人')
                  if (e.target.dataset.id == 'isshare') {
                    that.setData({ toshare: 0, sharesuccess: 1, isshare: 1 })
                  }
                }
              })
            }
            if (d.platform == 'ios') {//如果用户的设备是IOS
              if (res.shareTickets != undefined) {
                console.log("ios 分享的是群");
                wx.getShareInfo({
                  shareTicket: res.shareTickets,
                  success: function (res) {
                    //分享到群之后你要做的事情
                    if (e.target.dataset.id == 'isshare') {
                      that.setData({ toshare: 0, sharesuccess: 1, isshare: 1 })
                    }

                  }
                })

              } else {//分享到个人要做的事情，我给的是一个提示
                console.log("ios分享的是个人");
                if(e.target.dataset.id=='isshare'){
                  that.setData({ toshare: 0, sharesuccess: 1, isshare: 1 })
                }
                

              }
            }

          },
          fail: function (res) {

          }
        })
      }

    }


  },


  chooseanswer:function(e){
    //选择答案
    // console.log(e);

    if (this.data.isover == 1) {
      //当前答题已经结束
      return
    }


    this.setData({ isstart:1}) //标识已经答题了

    var selectid = e.currentTarget.dataset.id;
    var currentQ= this.data.currentQ;
    var answers = currentQ.answers

    for(var i=0;i<answers.length;i++){
      if (answers[i]['id'] == selectid) {
        //用户选择的答案
        answers[i]['userselect']=1
        answers[i]['step']=0; //停留在用户选择
        if (answers[i]['right_answer']==1){ //用户对了
          currentQ['right']=1;
        }else{ //答错了
          currentQ['right'] = 0;
        }
      }else{
        answers[i]['userselect']=0
      }
    }
    // console.log(currentQ)
    this.setData({ 'currentQ': currentQ})
    //wx.setStorageSync('currentQ', currentQ)
  },



  submitanswer:function(){
    var userinfo = wx.getStorageSync('userInfo');
    var that=this

    //判断今天的答题是否已经满了

    // if(userinfo.profittimes>=2){
    //   this.setData({ overbox: 1, isover:1})
    //   return;
    // }


    if(that.data.isover==1){
      //当前答题已经结束
      return
    }
    if (this.data.isstart == 2) {
      return;
    }
    if(this.data.isstart==0){
      that.setData({isstart:2})
      setTimeout(function(){
        that.setData({ isstart: 0 })
      },2000)

      return;
    }else{
      //var currentQ = wx.getStorageSync('currentQ');
      var currentQ = that.data.currentQ;
      wx.setStorageSync('currentQ', currentQ);
      var answers = currentQ.answers
      // console.log(currentQ)
      for (var i = 0; i < answers.length;i++){
        answers[i]['step']=1; //区别点击的步骤
        if (answers[i]['right_answer'] == 1 && answers[i]['userselect']) {
          answers[i]['rightAnswer']=2 //用户答对了
        } else if (answers[i]['right_answer']==1){
          //答错结束当前答题
          answers[i]['rightAnswer'] = 1 //标识正确答案
        }else{
          answers[i]['rightAnswer'] = 0;
        }
      }
      var answeroptions=''
      for(var i=0;i<answers.length;i++){
        if (answers[i].userselect==1){
          answeroptions = answers[i]['option']; //用户选择的选项
        }
      }
      currentQ.answers = answers
      // console.log(currentQ)
      wx.setStorageSync('currentQ', currentQ)

      apiV1(URL_ANSWER,{
        user_id: userinfo.id,
        question_id: currentQ.id,
        isright: currentQ.right,
        answer_options: answeroptions
      },data=>{
        console.log(data);
        if (data.status==1){
          
          that.setData({ currentQ: currentQ })
          if (currentQ.right == 0) {
            //答错了，显示继续答题按钮
            //回答错题的数量自增1
            userinfo.errorcount = parseInt(userinfo.errorcount) + 1
            wx.setStorageSync('userInfo', userinfo);
            var num=that.data.num;

            if(num>0){
              that.setData({ num: (parseInt(num)-1) });
            }else{
              that.setData({ num : 0 });
            }
            
            that.iserrorfn();
          } else {
            //答对了，继续下一题
            // that.nextquestion();
            //执行领取奖励
            //领完两次奖励直接答对直接进入下一题
            console.log(userinfo)
            // if (userinfo.profittimes>=2){
              //答对的题目自增1
              // userinfo.rightcount = parseInt(userinfo.rightcount)+1
              // wx.setStorageSync('userInfo', userinfo);
              // that.nextquestion();
            // }else{
              that.setData({ answerright: 1 });
            // }
            
          }

        }

      },true)




    }
  },


  //开启下一题
  nextquestion:function(){

    this.setcurrentQ((this.data.index))
  },

//分享完成获得一次答题机会
  tonextquestion:function(){

    var that=this;

    if(wx.getStorageSync('questions')){

      this.setData({ sharesuccess: 0 });
      wx.removeStorageSync('currentQ');
      this.nextquestion();

    }else{
      var user = wx.getStorageSync('userInfo');
      apiV1(URL_GET_QUESTIONS, { user_id: user.id }, function (res) {
        console.log(res);
        if (res.status == 1) {
          that.setData({ questions: res.data, sharesuccess: 0 });
          that.setcurrentQ(0);
          wx.setStorageSync('questions', res.data);
        }

      }, true)
    }
    


  },

  //回答错误的时候执行
  iserrorfn:function(){
    var that=this;
    that.setData({ isover: 1, iserror: 1 })
    setTimeout(function () {

//      if(that.data.num){ //判断当前是否还存在答题次数
        that.setData({ iserror: 0, goon: 1 })
      // }else{ 
      //   //需要分享来获得答题次数
      //   that.setData({ iserror: 0, toshare: 1 })
      // }
      


    }, 2000)
  },

  //继续答题
  goonanswer:function(){
    var that=this
    //判断答题次数
    if(this.data.num>0){
      this.nextquestion();
    }else{

      that.setData({toshare:1}) //显示分享提示

      //保存分享答题的状态
      /*
      var date=new Date();

      var str=date.getFullYear()+'/'+(date.getMonth()+1)+'/'+date.getDate();
      var timestamp=Date.parse(str);
      var share={
        timestamp: timestamp,
        toshare:1
      }

      wx.setStorageSync('toshare', share) //保存当前分享答题的状态
      this.setData({ toshare: 1, tosharenote:1})
      setTimeout(function(){
        that.setData({ tosharenote:0})
      },2000)
      */

      // 直接显示分享弹出层 



    }

    
  },

  openhongbaofn:function(){
    if(this.data.hongbaolock==1){ //快速点击也只能获取一次红包
      return;
    }
    this.setData({ hongbaolock:1})
    var userinfo = wx.getStorageSync('userInfo');
    var that=this;
    apiV1(URL_CREATECASE,{'user_id':userinfo.id},data=>{
      console.log(data)
      that.setData({ openhongbao: 1, answerright: 0, cash: data.data.count })

      userinfo['money']=data.data.money; //自动更新获得的奖金数
      userinfo['rightcount'] = parseInt(userinfo['rightcount'])+1; //答对的题自增1
      userinfo['profittimes'] = parseInt(userinfo['profittimes'])+1
      wx.setStorageSync('userInfo', userinfo)

    },true)
  },

  towallet:function(){
    wx.navigateTo({
      url:'/pages/tixian/tixian'
    })
  },



  //关闭今天已经领取两次红包按钮
  hideoverbox:function(){
    wx.navigateBack({
      delta: 1
    })
  },


  sharetopyq:function(){

    var that=this
    var questions = wx.getStorageSync('questions');

    var id = that.data.currentQ.id
    console.log(id)

    that.setData({
      isloading:1
    })
    apiV1(URL_GETIMAGE,{id:id},function(res){

      that.setData({
        isloading: 0
      })

      if (!(typeof res == 'object')){
        var res = that.toTrim(res);
        res = JSON.parse(res);
      }
      console.log(res)
      
      if(res.status==1){
        wx.setStorageSync('shareimage', res.data);
        wx.navigateTo({
          url: '/pages/forhelp/forhelp'
        })
      }
      
    },true)
  },

  toTrim: function (str) {
    return str.replace(/(^\s*)|(\s*$)/g, "");
  }





})