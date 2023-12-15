class ShopOrdersHandler
    attr_reader :shop_order_request
    attr_writer :shop_order_request

    def self.success(is_update)
        self.shop_order_request.success = true
        raise "Not implemented"
        
        begin
            if is_update
                # TODO: topic handler -> notifications
            else
                # TODO: topic handler -> stocks
            end
        rescue => error
            # TODO: handle error, retries?
        end
    end

    def self.rollback()
        raise "Not implemented"
    end

    def self.failure()
        self.shop_order_request.success = false

        begin
            self.rollback()
        rescue => error
            # TODO: handle error, retries?
            # TODO: topic handler -> notifications
        end
    end

    def self.generate_uuid()
        raise "Not implemented"
        return ""
    end

    def self.place_order()
        raise "Not implemented"
    end

    def self.process_shop_order_request()
        @uuid = self.generate_uuid()

        self.shop_order_request.shop_order_request_data.uuid = @uuid
        raise "Not implemented: Get TEAM_ID from .env"
        self.shop_order_request.groupId = TEAM_ID

        self.place_order()
    end

    def self.update_order()
        raise "Not implemented"
    end

    def self.process_shop_order_update()
        raise "Not implemented"
        self.update_order()
    end

    def self.is_update()
        return self.shop_order_request.shop_order_request_data.uuid != nil && self.shop_order_request.shop_order_request_data.uuid != ""
    end

    def self.process()
        if !@shop_order_request.success
            return self.failure()
        end

        @success = false
        @is_update = self.is_update()
        if @is_update
            @success = self.process_shop_order_update()
        else
            @success = self.process_shop_order_request()
        end

        if @success
            return self.success(@is_update)
        end

        return self.failure()
    end
end