var myNavBar = new NavBar(425);
var tempMenu;

myNavBar.setSizes(1,1,1);
myNavBar.setColors("black", "black", "#eeeeee", "#000000", "#BCBFC0", "#ffffff", "#0068d0", "#white", "#eeeeee");
myNavBar.setFonts("verdana", "plain", "bold", "9pt", "verdana", "plain", "bold", "8pt");
myNavBar.setAlign("center");

tempMenu = new NavBarMenu(85, 100);
    tempMenu.addItem(new NavBarMenuItem("&nbsp;Dru¿yna", "?dzial=1"));
    tempMenu.addItem(new NavBarMenuItem("&nbsp;Sk³ad","?poddzial=1"));
    tempMenu.addItem(new NavBarMenuItem("&nbsp;Hala","?poddzial=3"));
    tempMenu.addItem(new NavBarMenuItem("&nbsp;Informacje","?poddzial=4"));
    tempMenu.addItem(new NavBarMenuItem("&nbsp;Historia","?poddzial=5"));
myNavBar.addMenu(tempMenu);
tempMenu = new NavBarMenu(85, 110);
    tempMenu.addItem(new NavBarMenuItem("&nbsp;Liga", "?dzial=2"));
   tempMenu.addItem(new NavBarMenuItem("&nbsp;Terminarz","?poddzial=8"));
   tempMenu.addItem(new NavBarMenuItem("&nbsp;Wyniki i tabele","?poddzial=9"));
   tempMenu.addItem(new NavBarMenuItem("&nbsp;Kluby","?poddzial=10"));
   tempMenu.addItem(new NavBarMenuItem("&nbsp;Statystyki","?poddzial=17"));
   tempMenu.addItem(new NavBarMenuItem("&nbsp;Teksty","?poddzial=13"));
myNavBar.addMenu(tempMenu);
tempMenu = new NavBarMenu(85, 110);
    tempMenu.addItem(new NavBarMenuItem("&nbsp;2 liga", "?dzial=8"));
    tempMenu.addItem(new NavBarMenuItem("&nbsp;¦l±sk II","?poddzial=1"));
    tempMenu.addItem(new NavBarMenuItem("&nbsp;Terminarz","?poddzial=21"));
    tempMenu.addItem(new NavBarMenuItem("&nbsp;Wyniki i tabele","?poddzial=20"));
    tempMenu.addItem(new NavBarMenuItem("&nbsp;Statystyki","?poddzial=19"));
    tempMenu.addItem(new NavBarMenuItem("&nbsp;Teksty","?poddzial=19"));
myNavBar.addMenu(tempMenu);
tempMenu = new NavBarMenu(85, 110);
   tempMenu.addItem(new NavBarMenuItem("&nbsp;Euroliga", "?dzial=3"));
   tempMenu.addItem(new NavBarMenuItem("&nbsp;Terminarz","?poddzial=7"));
   tempMenu.addItem(new NavBarMenuItem("&nbsp;Wyniki i tabele","?poddzial=15"));
   tempMenu.addItem(new NavBarMenuItem("&nbsp;Kluby","?poddzial=16"));
   tempMenu.addItem(new NavBarMenuItem("&nbsp;Statystyki","?poddzial=18"));
   tempMenu.addItem(new NavBarMenuItem("&nbsp;Teksty","?poddzial=14"));
myNavBar.addMenu(tempMenu);
tempMenu = new NavBarMenu(85, 120);
    tempMenu.addItem(new NavBarMenuItem("&nbsp;Nasi...", "?dzial=4"));
    tempMenu.addItem(new NavBarMenuItem("&nbsp;... byli gracze","?poddzial=11"));
    tempMenu.addItem(new NavBarMenuItem("&nbsp;... przeciwnicy","?poddzial=12"));
myNavBar.addMenu(tempMenu);
tempMenu = new NavBarMenu(85, 120);
    tempMenu.addItem(new NavBarMenuItem("&nbsp;Inne", "?dzial=5"));
    tempMenu.addItem(new NavBarMenuItem("&nbsp;Forum","?poddzial=21"));
    tempMenu.addItem(new NavBarMenuItem("&nbsp;Chat","http://www.polchat.pl/chat/?room=slask.e-basket.pl"));
    tempMenu.addItem(new NavBarMenuItem("&nbsp;Multimedia","?poddzial=20"));
    tempMenu.addItem(new NavBarMenuItem("&nbsp;Linki","?poddzial=19"));
myNavBar.addMenu(tempMenu);

        function init2()
        {
                var img;
                var x=17;
                myNavBar.create();

                // Find the position of the embedded image and move bar accordingly, note
                // that we have to adjust for the table's cell padding.
                img = getImage("placeholder");

                        if(isMinNS4) x=17;
                        myNavBar.moveTo(getImagePageLeft(img) + 1, getImagePageTop(img) -x);
          
        }
