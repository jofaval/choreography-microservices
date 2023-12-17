import { NotificationsHandler } from "./src/handlers/notifications.handler";
import { read } from "./src/handlers/topic.handler";

// TODO: use dotenv
const TEAM_ID = 3;

read((shopOrderRequest) => {
  if (shopOrderRequest.groupId !== `team-${TEAM_ID}`) {
    return;
  }

  new NotificationsHandler(shopOrderRequest).process();
});
