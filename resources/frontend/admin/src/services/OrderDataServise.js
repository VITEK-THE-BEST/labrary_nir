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
    createOrderAdmin(data, date,user_id, token) {
        return http.post("api/admin/order/create/" + data.id, {
            "date_complete_order": date,
            "user_id": user_id

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

    completeOrder(book_id, token) {
        return http.get("api/order/complete/" + book_id, {
            headers: {
                'Authorization': "Bearer " + token,
                'Accept': 'application/json'
            },
        });
    }

    completeAdmin(book_id, user_id, token) {
        return http.get("api/admin/order/completeAdmin/" + book_id + '/' + user_id, {
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

    getAllCompleteOrder(token) {
        return http.get("api/admin/order/showAllCompleteOrder", {
            headers: {
                'Authorization': "Bearer " + token,
                'Accept': 'application/json'
            },
        });
    }

    getAllNotCompleteOrder(token) {
        return http.get("api/admin/order/showAllNotCompleteOrder", {
            headers: {
                'Authorization': "Bearer " + token,
                'Accept': 'application/json'
            },
        });
    }
};
