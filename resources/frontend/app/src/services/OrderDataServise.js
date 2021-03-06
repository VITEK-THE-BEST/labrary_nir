import http from "../http-common";

export default new class {
    create(data, date, token) {
        return http.post("api/order/create/" + data.id, {
            "date_complete_order": date
        }, {
            headers: {
                'Authorization': "Bearer " + token,
                'Accept': 'application/json'
            },
        });
    }



    getPrice(data) {
        return http.post("api/order/getPrice/" + data.id, {
            "date": data.date
        }, {
            headers: {
                'Accept': 'application/json'
            },
        });
    }
    getCompletePrice(data,token) {
        return http.get("api/order/getCompletePrice/" + data.id,  {
            headers: {
                'Authorization': "Bearer " + token,
                'Accept': 'application/json'
            },
        });
    }
    completeOrder(book_id, token) {
        return http.get("api/order/complete/" + book_id, {
            headers: {
                'Authorization': "Bearer " + token,
                'Accept': 'application/json'
            },
        });
    }

    getCompleteOrder(token) {
        return http.get("api/order/showCompleteOrder", {
            headers: {
                'Authorization': "Bearer " + token,
                'Accept': 'application/json'
            },
        });
    }

    getNotCompleteOrder(token) {
        return http.get("api/order/showNotCompleteOrder", {
            headers: {
                'Authorization': "Bearer " + token,
                'Accept': 'application/json'
            },
        });
    }
};
