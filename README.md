# Devclan_crawler-api
Devclan project, crawl news sites, create API for mobile and web rendering

baseURL for api endpoints devclangroup1.herokuapp.com

Other news outlets would be added later in the future as this endpoint has just one news outlet - ```guardian```

To get news by category:
        baseURL/guardian/{category} --- GET request
            example request(GET):
                  devclangroup1.herokuapp.com/guardian/money
            example response
                  [
                      {
                          "id": 4981,
                          "title": "British Gas owner hints bills could rise for second time this year",
                          "description": "Tariffs ‘under review’ as Centrica reports 20% profit fall and 341,000 lost customersCentrica, the owner of British Gas, has hinted that bills could go up for a second time this year, after reporting a 20% drop in profits at its consumer arm and more customer account losses.British Gas, the UK’s biggest energy supplier, lost 341,000 customer accounts in the UK in the first half of the year, although the rate of losses slowed. Operating profit at the business fell to £430m.  Continue reading...",
                          "link": "https://www.theguardian.com/business/2018/jul/31/british-gas-owner-hints-gas-bills-could-rise-for-second-time-this-year",
                          "category": "money",
                          "created_at": "2018-07-31 18:51:03",
                          "updated_at": "2018-07-31 18:51:03"
                      },
                      {
                          "id": 4991,
                          "title": "Dixons Carphone: 10m customers hit by data breach – investigation",
                          "description": "Group initially estimated 1.2 million customers had personal data stolen in massive attackDixons Carphone said an investigation into a massive data breach has found personal data belonging to 10 million customers may have been accessed last year, nearly 10 times as many as initially thought.The electronics retailer had estimated the attack involved unauthorised access to 1.2m personal records, when it first reported the breach in June. It said there was no evidence of any fraud.  Continue reading...",
                          "link": "https://www.theguardian.com/business/2018/jul/31/dixon-carphone-10m-customers-hit-by-data-breach-investigation",
                          "category": "money",
                          "created_at": "2018-07-31 18:51:03",
                          "updated_at": "2018-07-31 18:51:03"
                      },
                  ]

You can use this endpoint to access the list of categories available 
          baseURL/guardian/get/categories
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
