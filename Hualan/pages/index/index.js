//index.js
var page = undefined;
Page({
  onLoad: function () {
    page = this;
  },
  bindbt:function(){
    doommList.push(new Doomm("你是我的小苹果",Math.ceil(Math.random()*100),Math.ceil(Math.random()*10),getRandomColor()));
    console.log(doommList)
    this.setData({
      doommData : doommList
    })
  },
  data: {
    doommData:[]
  }
})
var doommList=[];
var i=0;
class Doomm{
  constructor(text,top,time,color){
    this.text = text+i;
    this.top = top;
    this.time = time;
    this.color = color;
    this.display = true;
    let that = this;
    this.id = i++;
    setTimeout(function(){
      doommList.splice(doommList.indexOf(that),1);
      page.setData({
      doommData : doommList
    })
    },this.time*1000)
  }
}
function getRandomColor() {
  let rgb = []
  for (let i = 0; i < 3; ++i) {
    let color = Math.floor(Math.random() * 256).toString(16)
    color = color.length == 1 ? '0' + color : color
    rgb.push(color)
  }
  return '#' + rgb.join('')
}