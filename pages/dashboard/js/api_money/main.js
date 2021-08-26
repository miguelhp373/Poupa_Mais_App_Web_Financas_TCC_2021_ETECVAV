 fetch(`https://economia.awesomeapi.com.br/last/USD-BRL,EUR-BRL,BTC-BRL`)
        .then(function (response) {
          if (!response.ok) {
            throw new Error(
              "Erro Ao Tentar Se Comunicar com o Servidor! Status " +
                response.status
            );
          } else {
            return response.json();
          }
        })

        .then(function (data) {
            
            console.log(data.BTCBRL.bid)
            document.getElementById('dollar_cotation').innerHTML += Number(data.USDBRL.bid).toFixed(2).replace('.',',')
            document.getElementById('eur_cotation').innerHTML += Number(data.EURBRL.bid).toFixed(2).replace('.',',')
            document.getElementById('bitcoin_cotation').innerHTML += data.BTCBRL.bid
        })
    
        .catch(function (error) {
          console.log(error.message);
        });
    