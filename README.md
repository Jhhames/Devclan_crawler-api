# Devclan_crawler-api
Devclan project, crawl news sites, create API for mobile and web rendering

baseURL for api endpoints devclangroup1.herokuapp.com
Other news outlets would be added later in the future as this endpoint has just one news outlet - ```guardian```

To get news by category:
        ```devclangroup1.herokuapp.com/guardian/{category}``` --- GET request
          example request(GET):
                  ```devclangroup1.herokuapp.com/guardian/money```


You can use this endpoint to access the list of categories available 
          ```devclangroup1.herokuapp.com/guardian/get/categories```
          You'll get this response 
          [
              "uk-news",
              "politics",
              "world",
              "sport",
              "football",
              "culture",
              "business",
              "lifeandstyle",
              "fashion",
              "environment",
              "technology",
              "travel",
              "money",
              "science"
          ]
