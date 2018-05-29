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
        this.newsItems[this.activeIndex].css('left', '100%');

        this.newsItems[this.activeIndex].animate({left: 0}, 'slow', 'linear', ()=>{
            setTimeout(()=>{
                let w1 = this.newsItems[this.activeIndex].width();
                let w2 = this.area.width();

                if (w2 >= w1) {
                    // 領域内に文言全て収まっているのであれば、そのままハケる
                    this.newsItems[this.activeIndex].animate({left: "-" + (w1 + 30) + "px"}, 'slow', 'linear', ()=>{
                        this.activeIndex++;
                        if (this.activeIndex == this.itemNum) {
                            this.activeIndex = 0;
                        }
                        this.start();
                    });
                } else {
                    // 領域内に収まっていなければ、一回右端で止まってからハケる
                    this.newsItems[this.activeIndex].animate({left: "-" + (w1 - w2 + 10) + "px"}, 'slow', 'linear', ()=>{
                        setTimeout(()=>{
                            this.newsItems[this.activeIndex].animate({left: "-" + (w1 + 30) + "px"}, 'slow', 'linear', ()=>{
                                this.activeIndex++;
                                if (this.activeIndex == this.itemNum) {
                                    this.activeIndex = 0;
                                }
                                this.start();
                            });
                        }, 2000);
                    });
                }

            }, 3000);
        });
    }
}