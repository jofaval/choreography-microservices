class ShopOrdersHandler
    attr_reader :shopOrderRequest
    attr_writer :shopOrderRequest

    def self.success(is_update)
        self.shopOrderRequest.success = true
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

    def self.compensate()
        raise "Not implemented"
    end

    def self.failure()
        self.shopOrderRequest.success = false

        begin
            self.compensate()
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

    def self.process_shopOrderRequest()
        @uuid = self.generate_uuid()

        self.shopOrderRequest.shopOrderRequestData.uuid = @uuid
        raise "Not implemented: Get TEAM_ID from .env"
        self.shopOrderRequest.groupId = TEAM_ID

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
        return self.shopOrderRequest.shopOrderRequestData.uuid != nil && self.shopOrderRequest.shopOrderRequestData.uuid != ""
    end

    def self.process()
        if !@shopOrderRequest.success
            return self.failure()
        end

        @success = false
        @is_update = self.is_update()
        if @is_update
            @success = self.process_shop_order_update()
        else
            @success = self.process_shopOrderRequest()
        end

        if @success
            return self.success(@is_update)
        end

        return self.failure()
    end
end