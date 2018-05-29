class Ticker {
    constructor(area)
    {
        this.area = $(area);
        this.news = $(this.area.children('ul')[0]);
        let newsItems = [];
        this.news.children('li').each(function (){
            newsItems.push($(this));
        });
        this.newsItems = newsItems;

        this.activeIndex = 0;
        this.itemNum = this.newsItems.length;
    }

    start()
    {
        this.newsItems[this.activeIndex].animate({left: 0}, 1500, 'linear', ()=>{
            setTimeout(()=>{
                this.newsItems[this.activeIndex].animate({left: "-" + this.newsItems[this.activeIndex].width() + "px"}, 1500, 'linear', ()=>{
                    this.activeIndex++;
                    if (this.activeIndex == this.itemNum) {
                        this.activeIndex = 0;
                    }
                    this.start();
                });
            }, 3000);
        });
    }
}